<?php

namespace Lychee\Photo;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/{id}', Http\Photo::class . '::photo');
        $controllers->get('/{id}/archive', Http\Photo::class . '::archive');

        return $controllers;
    }
}
