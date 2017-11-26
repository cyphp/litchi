<?php

namespace Lychee\Photo\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Modules\Photo as LycheePhoto;

class Photo
{
    public function photo(Request $request, Application $app, $id)
    {
        $photo = new LycheePhoto($id);
        $albumId = $request->query->get('albumID');
        
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

    public function archive(Request $request, Application $app, $id)
    {
        $photo = new LycheePhoto($id);

        if ($app['guard']->isAuthenticated()) {
            return $photo->getArchive();
        }

        if (2 === $photo->getPublic($request->query->get('password'))) {
            return $photo->getArchive();
        }
        
        // Photo private
        return $app->json('Warning: Album private or not downloadable!');
    }
}
