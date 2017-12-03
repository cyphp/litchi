<?php

namespace Lychee\Album;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

use Lychee\Auth;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/{id}', Http\Album::class . '::album');
        $controllers->get('/{id}/archive', Http\Album::class . '::archive');
        
        $controllers
            ->patch('/{id}', Http\Album::class . '::change')
            ->before(new Auth\Middleware\Auth());
        $controllers
            ->delete('/{id}', Http\Album::class . '::remove')
            ->before(new Auth\Middleware\Auth());
        $controllers
            ->post('/{id}/merge', Http\Album::class . '::merge')
            ->before(new Auth\Middleware\Auth());

        $controllers
            ->post('/', Http\Album::class . '::create')
            ->before(new Auth\Middleware\Auth());

        return $controllers;
    }
}
