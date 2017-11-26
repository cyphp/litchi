<?php

namespace Lychee\Albums;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app->mount('/albums', new ControllerProvider());
    }
}
