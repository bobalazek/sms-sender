<?php

use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

require __DIR__.'/prod.php';

$app['debug'] = true;

$app->register(new MonologServiceProvider(), [
    'monolog.logfile' => __DIR__.'/../var/logs/silex_dev.log',
]);

$app->register(new WebProfilerServiceProvider(), [
    'profiler.cache_dir' => __DIR__.'/../var/cache/profiler',
]);
