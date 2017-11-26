<?php

namespace Lychee\Search;

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
            ->get('/', Http\Search::class . '::search')
            ->before(new Auth\Middleware\Auth());

        return $controllers;
    }
}
