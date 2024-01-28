<?php

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');


Router::addGroup(
    '/api',
    function () {
        // user
        Router::addRoute(['GET'], '/users', 'App\Controller\UserController@index');
        Router::addRoute(['PUT'], '/user/{id}', 'App\Controller\UserController@update');
        Router::addRoute(['DELETE'], '/user/{id}', 'App\Controller\UserController@del');

        // Product
        Router::addRoute(['GET'], '/products', 'App\Controller\Product@index');
        Router::addRoute(['GET'], '/product/{uuid}', 'App\Controller\Product@show');
        Router::addRoute(['POST'], '/product', 'App\Controller\Product@create');
        Router::addRoute(['PUT'], '/product/{uuid}', 'App\Controller\Product@update');
        Router::addRoute(['DELETE'], '/product/{uuid}', 'App\Controller\Product@delete');

        // Squad
        Router::addRoute(['GET'], '/squads', 'App\Controller\SquadController@index');
        Router::addRoute(['GET'], '/squad/{uuid}', 'App\Controller\SquadController@show');
        Router::addRoute(['POST'], '/squad', 'App\Controller\SquadController@create');
        Router::addRoute(['PUT'], '/squad/{uuid}', 'App\Controller\SquadController@update');
        Router::addRoute(['DELETE'], '/squad', 'App\Controller\SquadController@delete');

        // Squad
        Router::addRoute(['GET'], '/squad/{uuid}/members', 'App\Controller\Member@index');
        Router::addRoute(['GET'], '/squad/{uuid}/member/{memberUuid}', 'App\Controller\Member@show');
        Router::addRoute(['POST'], '/squad/{uuid}/member', 'App\Controller\Member@create');
        Router::addRoute(['PUT'], '/squad/{uuid}/member/{memberUuid}', 'App\Controller\Member@update');
        Router::addRoute(['DELETE'], '/squad/{uuid}/member/{memberUuid}', 'App\Controller\Member@delete');
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
