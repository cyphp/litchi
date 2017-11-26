<?php

namespace Lychee\Album\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Modules\Albums;
use Lychee\Modules\Settings;

class Album
{
    public function all(Request $request, Application $app)
    {
        $albums = new Albums();

        if ($app['session']->get('login') &&
            $app['session']->get('identifier') === Settings::get()['identifier']
        ) {
            return $app->json($albums->get(false));
        }

        return $app->json($albums->get(true));
    }
}
