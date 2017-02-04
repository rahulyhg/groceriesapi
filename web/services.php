<?php

$app['db.connection'] = function () {
    $connection = new PDO(getenv('DATABASE_DSN'), getenv('DATABASE_USER'), getenv('DATABASE_PASS'));
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $connection;
};

$app['jwt.parser'] = function ($app) {
    return new Lcobucci\JWT\Parser();
};

$app['jwt.signer'] = function ($app) {
    return new Lcobucci\JWT\Signer\Hmac\Sha256();
};

$app['jwt.builder'] = function ($app) {
    return new Lcobucci\JWT\Builder();
};

$app['token.generator'] = function ($app) {
    return new Groceries\Api\TokenGenerator($app['jwt.builder'], $app['jwt.signer'],
                                            getenv('JWT_KEY'), getenv('JWT_ISSUER'), getenv('JWT_AUDIENCE'));
};

$app['id.generator'] = function ($app) {
    return new Groceries\Api\IDGenerator();
};

$app['access.control'] = function ($app) {
    return new Groceries\Api\AccessControl();
};

$app['request.decoding'] = function ($app) {
    return new Groceries\Api\RequestDecoding($app['serializer']);
};

$app['response.encoding'] = function ($app) {
    return new Groceries\Api\ResponseEncoding($app['serializer']);
};

$app['request.authentication'] = function ($app) {
    return new Groceries\Api\RequestAuthentication($app['jwt.parser'], $app['jwt.signer'], getenv('JWT_KEY'));
};

$app['credentials.data.access'] = function ($app) {
    return new Groceries\Credentials\RelationalDataAccess($app['db.connection']);
};

$app['lists.data.access'] = function ($app) {
    return new Groceries\Lists\RelationalDataAccess($app['db.connection']);
};

$app['items.data.access'] = function ($app) {
    return new Groceries\Items\RelationalDataAccess($app['db.connection']);
};

$app['options.resource.handler.v1'] = function ($app) {
    return new Groceries\Api\V1\OptionsResourceHandler();
};

$app['token.resource.handler.v1'] = function ($app) {
    return new Groceries\Api\V1\TokenResourceHandler($app['credentials.data.access'], $app['token.generator']);
};

$app['lists.resource.handler.v1'] = function ($app) {
    return new Groceries\Api\V1\ListsResourceHandler($app['lists.data.access'], $app['id.generator']);
};

$app['items.resource.handler.v1'] = function ($app) {
    return new Groceries\Api\V1\ItemsResourceHandler($app['items.data.access'], $app['id.generator']);
};
