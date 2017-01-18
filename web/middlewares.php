<?php

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\SerializerServiceProvider());

$app->before('request.body.decoder');

$app->get('/v1/tokens', 'tokens.resource.handler.v1:get');
$app->get('/v1/lists', 'lists.resource.handler.v1:get');
$app->get('/v1/lists/{list}/items', 'items.resource.handler.v1:get');

$app->post('/v1/lists', 'lists.resource.handler.v1:post');
$app->post('/v1/items', 'items.resource.handler.v1:post');

$app->delete('/v1/lists/{id}', 'lists.resource.handler.v1:delete');
$app->delete('/v1/items/{id}', 'items.resource.handler.v1:delete');
