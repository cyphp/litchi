<?php

namespace Lychee\Auth\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Lychee\Modules\Settings;

class Auth
{
    public function __invoke(Request $request, Application $app)
    {
        if (!$app['guard']->isAuthenticated()) {
            return $app->json('Error: Function not found! Please check the spelling of the called function.'); 
        }
    }
}
