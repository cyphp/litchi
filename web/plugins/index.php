<?php

use Symfony\Component\Debug\Debug;

require_once __DIR__.'/../../vendor/autoload.php';

Debug::enable();

include '../../src/index.php';

$app = require __DIR__.'/../../src/app.php';
require __DIR__.'/../../config/dev.php';
require __DIR__.'/../../src/controllers.php';
$app->run();