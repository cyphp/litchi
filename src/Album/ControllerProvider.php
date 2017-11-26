<?php

namespace Lychee\Album;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/{id}', Http\Album::class . '::album');
        $controllers->get('/{albumId}/photo/{photoId}', Http\Album::class . '::photo');

        return $controllers;
    }
}
