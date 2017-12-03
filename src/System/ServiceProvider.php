<?php

namespace Lychee\System;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

use Lychee\Access\Installation;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['system.config'] = function() use ($app) {
            return new Services\Configuration($app);
        };

        $app->mount('/setup', new ControllerProvider());

        // Check if a configuration exists
        $app->before(new Middleware\Setup(), Application::EARLY_EVENT);
        $app->before(new Middleware\JSONRequestBody());
    }
}
