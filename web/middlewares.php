<?php

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\SerializerServiceProvider());

$app->after('access.control');

$app->before('request.decoding');
$app->after('response.encoding');

$app->options('{anything}', 'options.resource.handler.v1:options')->assert('anything', '.*');

$app->get('/v1/token', 'token.resource.handler.v1:get');
$app->get('/v1/lists', 'lists.resource.handler.v1:get')->before('request.authentication');
$app->get('/v1/items', 'items.resource.handler.v1:get')->before('request.authentication');

$app->post('/v1/lists', 'lists.resource.handler.v1:post')->before('request.authentication');
$app->post('/v1/items', 'items.resource.handler.v1:post')->before('request.authentication');

$app->delete('/v1/lists/{id}', 'lists.resource.handler.v1:delete')->before('request.authentication');
$app->delete('/v1/items/{id}', 'items.resource.handler.v1:delete')->before('request.authentication');
