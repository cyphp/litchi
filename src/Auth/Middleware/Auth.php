<?php

namespace Lychee\Auth\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Lychee\Modules\Settings;
use Lychee\Access\Guest;

class Auth
{
    public function __invoke(Request $request, Application $app)
    {
        if ($request->isMethod('POST') && '/' === $request->getPathInfo()) {
            $fn = $request->request->get('function');

            if (!$app['guard']->isAuthenticated()) {
                return Guest::init($fn);
            }
        }
    }
}
