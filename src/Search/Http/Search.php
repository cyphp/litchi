<?php

namespace Lychee\Search\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Search
{
    public function search(Request $request, Application $app)
    {
        return $app->json(
            search($request->request->get('term'))
        );
    }
}
