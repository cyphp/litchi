<?php

namespace Lychee\System;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/', Http\Setup::class . '::status');
        $controllers->post('/', Http\Setup::class . '::create');

        return $controllers;
    }
}
