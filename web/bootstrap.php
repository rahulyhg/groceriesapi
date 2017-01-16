<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__ . '/services.php';
require __DIR__ . '/resources.php';

return $app;
