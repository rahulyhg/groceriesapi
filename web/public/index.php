<?php

$app = require __DIR__ . '/../bootstrap.php';
$app['debug'] = getenv('SERVER') === 'development';

$app->run();
