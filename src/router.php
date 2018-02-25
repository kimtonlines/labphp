<?php

$app->get('/', \Controller\Controller::class.':home');

$app->get('/article', \Controller\Controller::class.':getArticles');