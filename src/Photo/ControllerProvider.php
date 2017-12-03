<?php

namespace Lychee\Photo;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

use Lychee\Auth;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/{id}', Http\Photo::class . '::photo');
        $controllers->get('/{id}/archive', Http\Photo::class . '::archive');

        $controllers
            ->post('/', Http\Photo::class . '::create')
            ->before(new Auth\Middleware\Auth());
        $controllers
            ->delete('/{id}', Http\Photo::class . '::remove')
            ->before(new Auth\Middleware\Auth());
        $controllers
            ->post('/{id}/duplicate', Http\Photo::class . '::duplicate')
            ->before(new Auth\Middleware\Auth());
        $controllers
            ->patch('/{id}', Http\Photo::class . '::change')
            ->before(new Auth\Middleware\Auth());

        return $controllers;
    }
}
