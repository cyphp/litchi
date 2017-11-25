<?php

namespace Lychee\Dock\Middleware;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RequestIntegrity
{
    public function __invoke(Request $request, Application $app)
    {
        if (!$request->request->has('function') && !$request->query->has('function')) {
            return new JsonResponse('No API function specified!', 400);
        }
    }
}
