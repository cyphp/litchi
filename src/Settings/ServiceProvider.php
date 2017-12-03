<?php

namespace Lychee\Settings;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app->mount('/settings', new ControllerProvider());
    }
}
