<?php

namespace Lychee\Auth\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Modules\Settings;

class Auth
{
    public function status(Request $request, Application $app)
    {
        $settings = Settings::get();
        $authCredentialsCorrupted = (!Settings::get()['username'] && !Settings::get()['password']);
        $return = [];

        unset(
            $settings['username'],
            $settings['password'],
            $settings['identifier']
        );

        if ($app['guard']->isAuthenticated()) {
            $return['status'] = LYCHEE_STATUS_LOGGEDIN;
            $return['config'] = $settings;
            $return['config']['login'] = !$authCredentialsCorrupted;

            return $app->json($return);
        }

        $return['status'] = LYCHEE_STATUS_LOGGEDOUT;

        unset($settings['skipDuplicates']);
        unset($settings['sortingAlbums']);
        unset($settings['sortingPhotos']);
        unset($settings['dropboxKey']);
        unset($settings['login']);
        unset($settings['location']);
        unset($settings['imagick']);
        unset($settings['plugins']);

        $return['config'] = $settings;
        $return['config']['login'] = !$authCredentialsCorrupted;

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

    public function change(Request $request, Application $app)
    {
        $oldPassword = $request->request->get('oldPassword') ?: '';

        return $app->json(
            Settings::setLogin(
                $oldPassword,
                $request->request->get('username'),
                $request->request->get('password')
            )
        );

    }
}
