<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

Debug::enable();

$dotenv = new Dotenv();

$dotenv->load(LYCHEE_DATA . 'database.env');

// include '../../src/index.php';

$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/dev.php';
require __DIR__.'/../src/controllers.php';

$app->run();