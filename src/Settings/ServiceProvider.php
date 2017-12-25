<?php

namespace Lychee\Settings;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['pref'] = function() use($app) {
            $pref = new Service\Preference(
                new Data\SettingsRepository($app['db'])
            );

            $pref->pull();

            return $pref;
        };
        
        $app->mount('/settings', new ControllerProvider());
    }
}
