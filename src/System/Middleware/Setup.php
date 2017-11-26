<?php

namespace Lychee\System\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Setup
{
    public function __invoke(Request $request, Application $app)
    {
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
    }
}
