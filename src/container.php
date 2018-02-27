<?php

// Get container
$container = $app->getContainer();

$container['twig'] = function ($container) {

    $loader = new Twig_Loader_Filesystem('../views');

    $twig = new Twig_Environment($loader, array(
    //'cache' => '/path/to/compilation_cache',
    ));

    return $twig;

};



// Register component on container
/*$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig($dir.'/views', [
       // 'cache' => 'path/to/cache'
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};*/