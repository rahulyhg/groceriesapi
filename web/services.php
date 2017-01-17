<?php

$app['db.connection'] = function () {
    $connection = new PDO(getenv('DATABASE_DSN'), getenv('DATABASE_USER'), getenv('DATABASE_PASS'));
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $connection;
};

$app['uuid.generator'] = function ($app) {
    return new Groceries\Api\UuidGenerator();
};

$app['request.body.decoder'] = function ($app) {
    return new Groceries\Api\RequestBodyDecoder($app['serializer']);
};

$app['lists.data.access'] = function ($app) {
    return new Groceries\Lists\RelationalDataAccess($app['db.connection']);
};

$app['lists.resource.handler.v1'] = function ($app) {
    return new Groceries\Api\V1\ListsResourceHandler($app['lists.data.access'], $app['uuid.generator']);
};

$app['items.data.access'] = function ($app) {
    return new Groceries\Items\RelationalDataAccess($app['db.connection']);
};

$app['items.resource.handler.v1'] = function ($app) {
    return new Groceries\Api\V1\ItemsResourceHandler($app['items.data.access'], $app['uuid.generator']);
};
