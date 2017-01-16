<?php

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->get('/v1/lists', 'lists.resource.handler.v1:get');
