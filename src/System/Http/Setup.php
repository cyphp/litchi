<?php

namespace Lychee\System\Http;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Lychee\Modules\Config;

class Setup
{
    public function status(Request $request, Application $app)
    {
        return $app->json([
            'status' => LYCHEE_STATUS_NOCONFIG
        ]);
    }

    public function create(Request $request, Application $app)
    {
        return $app->json(
            Config::create($_POST['dbHost'], $_POST['dbUser'], $_POST['dbPassword'], $_POST['dbName'], $_POST['dbTablePrefix'])
        );
    }
}
