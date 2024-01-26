<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');


Router::addGroup(
    '/api',
    function () {
        // user
        Router::addRoute(['GET'], '/users', 'App\Controller\UserController@index');
        Router::addRoute(['PUT'], '/user/{id}', 'App\Controller\UserController@update');
        Router::addRoute(['DELETE'], '/user/{id}', 'App\Controller\UserController@del');

        // Squad
        Router::addRoute(['GET', 'HEAD'], '/squads', 'App\Controller\SquadController@index');
        Router::addRoute(['POST'], '/squad', 'App\Controller\SquadController@create');
        Router::addRoute(['PUT'], '/squad', 'App\Controller\SquadController@update');
        Router::addRoute(['DELETE'], '/squad', 'App\Controller\SquadController@del');

        // Product
        Router::addRoute(['GET'], '/products', 'App\Controller\ProductController@index');
        Router::addRoute(['POST'], '/product', 'App\Controller\ProductController@create');
        Router::addRoute(['PUT'], '/product', 'App\Controller\ProductController@update');
        Router::addRoute(['DELETE'], '/product', 'App\Controller\ProductController@del');
    },
    ['middleware' => [App\Middleware\AuthMiddleware::class]]
);

Router::get('/favicon.ico', function () {
    return '';
});

Router::addGroup('/api', function () {
    Router::post('/login', 'App\Controller\AuthController@login');
    Router::addRoute(['POST'], '/user', 'App\Controller\UserController@create');
});
