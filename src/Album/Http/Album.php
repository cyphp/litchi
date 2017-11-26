<?php

namespace Lychee\Album\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Modules\Album as LycheeAlbum;
use Lychee\Modules\Photo;

class Album
{
    public function album(Request $request, Application $app, $id)
    {
        $album = new LycheeAlbum($id);
        $preflight = $request->query->get('preflight');

        if ($app['guard']->isAuthenticated()) {
            return $app->json($album->get());
        }

        if (!$album->getPublic()) {
            // Album private
            return $app->json($preflight ? false : 'Warning: Album private!');
        }
        
        // Album public
        if ($album->checkPassword($request->query->get('password'))===true) {
            return $app->json($preflight ? true : $album->get());
        }

        return $app->json($preflight ? false : 'Warning: Wrong password!');
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
