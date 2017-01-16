<?php

$app['db.connection'] = function () {
    $connection = new PDO(getenv('DATABASE_DSN'), getenv('DATABASE_USER'), getenv('DATABASE_PASS'));
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $connection;
};
