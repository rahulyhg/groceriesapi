<?php

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\SerializerServiceProvider());

$app->get('/v1/lists', 'lists.resource.handler.v1:get');
$app->get('/v1/lists/{list}/items', 'items.resource.handler.v1:get');