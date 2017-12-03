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

        $controllers->get('/', Http\Auth::class . '::status');
        $controllers->post('/', Http\Auth::class . '::login');
        $controllers->delete('/', Http\Auth::class . '::logout');
        $controllers->patch('/', Http\Auth::class . '::change');

        return $controllers;
    }
}
