<?php

namespace Lychee\Auth\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Access\Guest;
use Lychee\Modules\Settings;

class Auth
{
    public function authenticate(Request $request, Application $app)
    {
        $fn = $request->request->get('function');

        switch ($fn) {
            case 'Session::init':
                return $this->status($request, $app);
            case 'Session::login':
                return $this->login($request, $app);
            case 'Session::logout':
                return $this->logout($request, $app);
            default:
                $app['monolog']->debug('are really here');
                Guest::init($fn);
                exit();
        }
    }

    public function status(Request $request, Application $app)
    {
        $return['config'] = Settings::get();
        
        // Path to Lychee for the server-import dialog
        $return['config']['location'] = LYCHEE;

        // Remove sensitive from response
        unset($return['config']['username']);
        unset($return['config']['password']);
        unset($return['config']['identifier']);

        // Check if login credentials exist and login if they don't
        if (!Settings::get()['username'] && !Settings::get()['password']) {
            $public = false;
            $return['config']['login'] = false;
            $return['status'] = LYCHEE_STATUS_LOGGEDIN;
        } else {
            $return['config']['login'] = true;
            $return['status'] = LYCHEE_STATUS_LOGGEDOUT;

            // Unset unused vars
            unset($return['config']['skipDuplicates']);
            unset($return['config']['sortingAlbums']);
            unset($return['config']['sortingPhotos']);
            unset($return['config']['dropboxKey']);
            unset($return['config']['login']);
            unset($return['config']['location']);
            unset($return['config']['imagick']);
            unset($return['config']['plugins']);
        }
        
        return $app->json($return);
    }

    public function login(Request $request, Application $app)
    {
        $username_crypt = crypt($request->request->get('user'), Settings::get()['username']);
		$password_crypt = crypt($request->request->get('password'), Settings::get()['password']);

		// Check login with crypted hash
		if (Settings::get()['username'] === $username_crypt &&
            Settings::get()['password'] === $password_crypt
        ) {
            $app['session']->set('login', true);
            $app['session']->set('identifier', Settings::get()['identifier']);
            
            return $app->json(true);
        }

		return $app->json(!Settings::get()['username'] && !Settings::get()['password']);
    }

    public function logout(Request $request, Application $app)
    {
        $app['session']->clear();

		return $app->json(true);
    }
}
