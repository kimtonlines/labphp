<?php

// Get container
$container = $app->getContainer();

$dir = dirname(__DIR__);

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig($dir.'/views', [
       // 'cache' => 'path/to/cache'
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};