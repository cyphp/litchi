<?php

namespace Lychee\Auth;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['guard'] = function() use ($app) {
            $guard = new Service\Guard(
                new Data\GuardRepository($app['db']), $app
            );

            $guard->pull();

            return $guard;
        };

        $app->mount('/auth', new ControllerProvider());
    }
}
