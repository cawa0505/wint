<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
    //'domain'	    => 'admin.mtlife.cn',
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/lists/university','Lists\UniversityController@index');
});
