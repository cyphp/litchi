<?php

namespace Lychee\Album\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Modules\Album as LycheeAlbum;

class Album
{
    public function one(Request $request, Application $app, $id)
    {
        $album = new LycheeAlbum($id);

        if ($app['guard']->isAuthenticated()) {
            return $app->json($album->get());
        }

        if ($album->getPublic()===true) {
            // Album public
            if ($album->checkPassword($request->request->get('password')===true)) {
                return $app->json($album->get());
            } else {
                return $app->json('Warning: Wrong password!');
            }
        } else {
            // Album private
            return $app->json('Warning: Album private!');
        }
    }
}
