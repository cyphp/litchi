<?php

namespace Lychee\System\Services;

use Silex\Application;
use Symfony\Component\Filesystem\Filesystem;

class Configuration
{
    protected $app;
    protected $fs;

    public function __construct(Application $app) {
        $this->app = $app;
        $this->fs = new FileSystem();
    }

    public function exists() {
        return $this->fs->exists(LYCHEE_CONFIG_FILE);
    }
}
