<?php

namespace Lychee\System;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Lychee\Access\Installation;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['system.config'] = function() use($app) {
            return new Services\Configuration($app);
        };

        $app->mount('/setup', new ControllerProvider());

        // Check if a configuration exists
        $app->before(function (Request $request, Application $app) {
            // by pass, since we load the html in the first place
            if (!$request->isMethod('POST')) {
                return;
            }

            if (!$app['system.config']->exists()) {    
                /**
                * Installation Access
                * Limited access to configure Lychee. Only available when the config.php file is missing.
                */
                $subRequest = Request::create(
                    '/setup/',
                    $request->request->get('function') === 'Config::create' ? 'POST' : 'GET',
                    $request->request->all()
                );
                
                return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
            }
        }, Application::EARLY_EVENT);
    }
}
