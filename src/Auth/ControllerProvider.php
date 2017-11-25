<?php

namespace Lychee\Auth;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->post('/', Http\Auth::class . '::authenticate');

        $controllers->get('/', Http\Auth::class . '::status');
        // $controllers->post('/', Http\Auth::class . '::login');
        // $controllers->delete('/', Http\Auth::class . '::logout');

        return $controllers;
    }
}
