<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'Api\RegisterController@register');
Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Edu', 'prefix' => 'edu'], function () {
        Route::resource('userBasicInfo', 'UserBasicInfoController');
        Route::resource('schedule', 'ScheduleController@index',['only'=>'index,show']);
        Route::resource('coursetake', 'CoursetakeController',['only'=>'index,show']);
        Route::resource('course', 'CourseController',['only'=>'index,show']);
        Route::resource('exam', 'ExamController',['only'=>'index,show,store,destroy']);
        Route::resource('grade', 'GradeController',['only'=>'index,show']);
        Route::resource('credit', 'GradeController',['only'=>'index']);
        Route::get('init', 'UserBasicInfoController@init');
    });
});

