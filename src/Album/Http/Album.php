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

    public function archive(Request $request, Application $app, $id)
    {
        $album = new LycheeAlbum($id);

        if ($app['guard']->isAuthenticated()) {
            return $album->getArchive();
        }

        if (!$album->getPublic() || !$album->getDownloadable()) {
            // Album private
            return $app->json('Warning: Album private or not downloadable!');
        }
        
        // Album public
        if ($album->checkPassword($request->query->get('password'))===true) {
            return $album->getArchive();
        }

        return $app->json('Warning: Wrong password!');
    }

    public function create(Request $request, Application $app)
    {
        $album = new LycheeAlbum(null);

		return $app->json($album->add($request->request->get('title')));
    }

    public function change(Request $request, Application $app, $id)
    {
        $album = new LycheeAlbum($id);

        $changed = true;

        if ($request->request->has('title')) {
            $changed = $changed && $album->setTitle($request->request->get('title'));
        }

        if ($request->request->has('description')) {
            $changed = $changed && $album->setDescription($request->request->get('description'));
        }

        if ($request->request->has('public') &&
            $request->request->has('password') &&
            $request->request->has('visible') &&
            $request->request->has('downloadable')
        ) {
            $changed = $changed && $album->setDescription(
                $album->setPublic(
                    $request->request->get('public'),
                    $request->request->get('password'),
                    $request->request->get('visible'),
                    $request->request->get('downloadable')
                )
            );
        }

		return $app->json($changed);
    }

    public function remove(Request $request, Application $app, $id)
    {
        $album = new LycheeAlbum($id);

		return $app->json($album->delete());
    }

    public function merge(Request $request, Application $app, $id)
    {
        $album = new LycheeAlbum($request->request->get('albumIDs'));

		return $app->json($album->merge());
    }
}
