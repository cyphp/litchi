<?php

namespace Lychee\Settings;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

use Lychee\Auth;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers
          ->post('/sorting', Http\Settings::class . '::sorting')
          ->before(new Auth\Middleware\Auth());
        $controllers
          ->post('/integration', Http\Settings::class . '::integration')
          ->before(new Auth\Middleware\Auth());

        return $controllers;
    }
}
