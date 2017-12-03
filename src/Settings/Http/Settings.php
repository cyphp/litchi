<?php

namespace Lychee\Settings\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Modules\Settings as LycheeSettings;

class Settings
{
    public function sorting(Request $request, Application $app)
    {
        $sA = LycheeSettings::setSortingAlbums($request->request->get('typeAlbums'), $request->request->get('orderAlbums'));
        $sP = LycheeSettings::setSortingPhotos($request->request->get('typePhotos'), $request->request->get('orderPhotos'));
        
        return $app->json($sA && $sP);
    }

    public function integration(Request $request, Application $app)
    {
        if ($request->request->has('dropboxKey')) {
            return $app->json(LycheeSettings::setDropboxKey($request->request->get('key')));
        }

        return $app->json(false);
    }
}
