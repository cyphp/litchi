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

    public function create(Request $request, Application $app)
    {
        $photo = new LycheePhoto(null);

		return $app->json($photo->add($_FILES, $request->request->get('albumID')));
    }

    public function remove(Request $request, Application $app, $id)
    {
        $photo = new LycheePhoto($id);

		return $app->json($photo->delete());
    }

    public function duplicate(Request $request, Application $app, $id)
    {
        $photo = new LycheePhoto($id);

		return $app->json($photo->duplicate());
    }

    public function change(Request $request, Application $app, $id)
    {
        $photo = new LycheePhoto($id);
        
        $changed = true;

        if ($request->request->has('title')) {
            $changed = $changed && $photo->setTitle($request->request->get('title'));
        }

        if ($request->request->has('description')) {
            $changed = $changed && $photo->setDescription($request->request->get('description'));
        }

        if ($request->request->get('star')) {
            $changed = $changed && $photo->setStar();
        }

        if ($request->request->get('public')) {
            $changed = $changed && $photo->setPublic();
        }

        if ($request->request->has('tags')) {
            $changed = $changed && $photo->setTags($request->request->get('tags'));
        }

        if ($request->request->has('albumID')) {
            $changed = $changed && $photo->setAlbum($request->request->get('albumID'));
        }

        return $app->json($changed);
    }
}
