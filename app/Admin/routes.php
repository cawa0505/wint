<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
    //'domain'		=> 'admin.mtlife.cn',
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/lists/university','Lists\UniversityController');
    $router->resource('/lists/college','Lists\CollegeController');
    $router->resource('/lists/profession','Lists\ProfessionController');
    $router->resource('/edu/university','Education\UniversityInfoController');
    $router->resource('/edu/course','Education\CourseController');
    $router->get('/api/china-area/city','Lists\UniversityController@cityList');
    $router->get('/api/china-area/district','Lists\UniversityController@districtList');
    $router->get('/api/china-area/college','Lists\ProfessionController@collegeList');
});
