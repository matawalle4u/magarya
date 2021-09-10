<?php

    declare(strict_types=1);
    require_once 'src/Router.php';
    use App\Router;

    $router = new Router();

    $router->get('/', function (){
        require_once __DIR__ .'/src/templates/homepage.html' ;
    });

    $router->get('/about', function (){
        require_once __DIR__ .'/src/templates/about.html' ;
    });

    $router->addNotFoundHandler( function (){
        //echo __DIR__ .'/src/templates' ;
        require_once __DIR__ .'/src/templates/404.phtml' ;
    });

    $router->run();




?>