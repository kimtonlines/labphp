<?php

$app->get('/', \Controller\Controller::class.':home');

$app->get('/article', \Controller\Controller::class.':list');

$app->get('/article/vider', \Controller\Controller::class.':truncate');


$app->get('/article/ajouter', \Controller\Controller::class.':create');
$app->post('/article/ajouter', \Controller\Controller::class.':create');

$app->get('/article/{id}', \Controller\Controller::class.':show');

$app->get('/article/supprimer/{id}', \Controller\Controller::class.':delete');
$app->delete('/article/supprimer/{id}', \Controller\Controller::class.':delete');

$app->get('/article/modifier/{id}', \Controller\Controller::class.':update');
$app->post('/article/modifier/{id}', \Controller\Controller::class.':update');