<?php

namespace Lychee\Auth;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['guard'] = function() use ($app) {
            return new Service\Guard($app);
        };

        $app->mount('/auth', new ControllerProvider());

        // $app->before(new Middleware\Auth());
    }
}
