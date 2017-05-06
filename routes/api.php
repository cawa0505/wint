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

Route::post('register', 'Api\RegisterController@register');
Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::resource('edu\userBasicInfo', 'Edu\UserBasicInfoController');
    Route::group(['namespace' => 'Edu', 'prefix' => 'edu', 'middleware' => 'HasBindEdu'], function () {
        Route::resource('schedule', 'ScheduleController', ['only' => ['index', 'show']]);
        Route::resource('coursetake', 'CoursetakeController', ['only' => ['index', 'show']]);
        Route::resource('course', 'CourseController', ['only' => ['index', 'show']]);
        Route::resource('exam', 'ExamController', ['only' => ['index', 'show', 'store', 'destroy']]);
        Route::resource('grade', 'GradeController', ['only' => ['index', 'show']]);
        Route::resource('credit', 'GradeController', ['only' => ['index', 'show']]);
        Route::get('init', 'UserBasicInfoController@init');
    });
});

