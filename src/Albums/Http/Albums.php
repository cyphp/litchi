<?php

namespace Lychee\Albums\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Modules\Albums as LycheeAlbums;

class Albums
{
    public function all(Request $request, Application $app)
    {
        $albums = new LycheeAlbums();

        if ($app['guard']->isAuthenticated()) {
            return $app->json($albums->get(false));
        }

        return $app->json($albums->get(true));
    }
}
