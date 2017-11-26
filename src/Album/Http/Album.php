<?php

namespace Lychee\Album\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Modules\Album as LycheeAlbum;
use Lychee\Modules\Photo;

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

    public function photo(Request $request, Application $app, $albumId, $photoId)
    {
        $photo = new Photo($photoId);
        
        if ($app['guard']->isAuthenticated()) {
            return $app->json($photo->get($albumId));
        }
        
        $pgP = $photo->getPublic($request->request->get('password'));

        if ($pgP===2) {
            return $app->json($photo->get($albumId));
        }
        
        if ($pgP===1) {
            return $app->json('Warning: Wrong password!');
        }
        
        return $app->json('Warning: Photo private!');
    }
}
