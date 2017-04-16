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
        Route::resource('UserBasicInfo', 'UserBasicInfoController');
        Route::resource('Schedule', 'ScheduleController');
        Route::resource('Coursetake', 'CoursetakeController');
        Route::resource('Exam', 'ExamController');
        Route::resource('Grade', 'GradeController');
        Route::resource('Credit', 'GradeController');
        Route::get('Init', 'UserBasicInfoController@init');
    });
});

