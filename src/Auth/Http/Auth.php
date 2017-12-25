<?php

namespace Lychee\Auth\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Modules\Settings;

class Auth
{
    public function status(Request $request, Application $app)
    {
        $return = [];
        $settings = $app['pref']->toArray();

        $return['config'] = $settings;
        $return['config']['login'] = !$app['guard']->credentialExists();

        if ($app['guard']->isAuthenticated()) {
            $return['status'] = LYCHEE_STATUS_LOGGEDIN;

            return $app->json($return);
        }

        $return['status'] = LYCHEE_STATUS_LOGGEDOUT;

        unset($return['config']['skipDuplicates']);
        unset($return['config']['sortingAlbums']);
        unset($return['config']['sortingPhotos']);
        unset($return['config']['dropboxKey']);
        unset($return['config']['login']);
        unset($return['config']['location']);
        unset($return['config']['imagick']);
        unset($return['config']['plugins']);

        return $app->json($return);
    }

    public function login(Request $request, Application $app)
    {
		// Check login with crypted hash
		if ($app['guard']->matchCredential($request->request->get('user'), $request->request->get('password'))) {
            $app['session']->set('login', true);
            $app['session']->set('identifier', $app['guard']->getIdentifier());
            
            return $app->json(true);
        }

		return $app->json($app['guard']->credentialExists());
    }

    public function logout(Request $request, Application $app)
    {
        $app['session']->clear();

		return $app->json(true);
    }

    public function change(Request $request, Application $app)
    {
        $success = $app['guard']->saveCredential(
            $request->request->get('username'),
            $request->request->get('password')
        );

        if ($success['username'] && $success['password']) {
            return $app->json(true);
        }

        $error = '';

        if (!$success['username']) {
            $error .= 'Updating username failed! ';
        }

        if (!$success['password']) {
            $error .= 'Updating password failed!';
        }

        return $app->json('Error: ' . $error);
    }
}
