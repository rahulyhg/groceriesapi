<?php

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\SerializerServiceProvider());

$app->before('request.body.decoder');

$app->get('/v1/lists', 'lists.resource.handler.v1:get');
$app->get('/v1/lists/{list}/items', 'items.resource.handler.v1:get');

$app->post('/v1/lists', 'lists.resource.handler.v1:post');
