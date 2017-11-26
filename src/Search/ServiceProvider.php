<?php

namespace Lychee\Search;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app->mount('/search', new ControllerProvider());
    }
}
