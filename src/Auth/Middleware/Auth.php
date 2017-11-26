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

            if (!$app['session']->get('login') ||
                $app['session']->get('identifier') !== Settings::get()['identifier']
            ) {
                return Guest::init($fn);
            }
        }
    }
}
