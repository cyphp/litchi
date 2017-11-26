<?php

namespace Lychee\Auth\Service;

use Silex\Application;

use Lychee\Modules\Settings;

class Guard
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function isAuthenticated()
    {
        return $this->app['session']->get('login') &&
            $this->app['session']->get('identifier') === Settings::get()['identifier'];
    }
}