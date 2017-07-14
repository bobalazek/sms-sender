<?php

use Symfony\Component\Debug\Debug;

if (
    isset($_SERVER['HTTP_CLIENT_IP']) ||
    isset($_SERVER['HTTP_X_FORWARDED_FOR']) ||
    !in_array(@$_SERVER['REMOTE_ADDR'], [
        '127.0.0.1',
        'fe80::1',
        '::1',
    ])
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once __DIR__.'/../vendor/autoload.php';

Debug::enable();

$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/dev.php';
require __DIR__.'/../src/controllers.php';
require __DIR__.'/../src/controllers/api.php';
require __DIR__.'/../src/controllers/database.php';
$app->run();