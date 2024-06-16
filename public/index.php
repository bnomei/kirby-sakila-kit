<?php

function cspHeaders()
{
    // CSP headers (or via plugin)
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');
    // strict
    header('Content-Security-Policy: default-src data:; script-src \'self\' \'unsafe-inline\' \'unsafe-eval\'; connect-src \'self\'; style-src \'self\' \'unsafe-inline\'; img-src data: \'self\';');
    // loose for jquery/alpinejs/etc...
    // header('Content-Security-Policy: default-src https: data: \'unsafe-inline\' \'unsafe-eval\'; script-src \'self\' \'unsafe-inline\' \'unsafe-eval\'; style-src \'self\' \'unsafe-inline\' \'unsafe-eval\'; img-src data: \'self\';');
    header('strict-transport-security: max-age=31536000; includeSubdomains');
    header('Referrer-Policy: no-referrer-when-downgrade');
    header('X-Powered-By: PHP');
}
// some basic security headers to avoid some common attacks
cspHeaders();

$time = microtime(true);

require_once __DIR__.'/../vendor/autoload.php';

// disable on [main] branch
\Bnomei\BoostDirInventory::singleton([
    'enabled' => false,
]);

// using a public/storage folder setup to protect
// some files (like .env) from being accessed directly
// in moving the web root folder to the public folder
$kirby = new Kirby([
    'roots' => [
        'index' => __DIR__,
        'media' => __DIR__.'/media',
        'base' => $base = dirname(__DIR__),
        'site' => $base.'/site',
        'storage' => $storage = $base.'/storage',
        'content' => $storage.'/content',
        'accounts' => $storage.'/accounts',
        'cache' => $storage.'/cache',
        'license' => $storage.'/',
        'logs' => $storage.'/logs',
        'sessions' => $storage.'/sessions',
    ],
]);

// set the config value of rendertime to true
// to measure the time it takes to render the page
if ($kirby->option('stopwatch')) {
    $time = microtime(true) - $time;
    header('X-Stopwatch-Load: '.number_format($time * 1000, 0).'ms');

    $time = microtime(true);
    $render = $kirby->render();
    $time = microtime(true) - $time;
    header('X-Stopwatch-Render: '.number_format($time * 1000, 0).'ms');
    echo $render;
} else {
    echo $kirby->render();
}
