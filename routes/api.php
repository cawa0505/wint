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
    Route::resource('edu/userBasicInfo', 'Edu\UserBasicInfoController');
    Route::group(['namespace' => 'Edu', 'prefix' => 'edu', 'middleware' => 'HasBindEdu'], function () {
        Route::resource('schedule', 'ScheduleController', ['only' => ['index', 'show']]);
        Route::resource('coursetake', 'CoursetakeController', ['only' => ['index', 'show']]);
        Route::resource('course', 'CourseController', ['only' => ['index', 'show']]);
        Route::resource('exam', 'ExamController', ['only' => ['index', 'show', 'store', 'destroy']]);
        Route::resource('grade', 'GradeController', ['only' => ['index', 'show']]);
        Route::resource('credit', 'CreditController', ['only' => ['index', 'show']]);
        Route::get('init', 'UserBasicInfoController@init')->name("初始化数据");
        Route::get('func_list', 'UserBasicInfoController@getUniversityFunctionList')->name("获取学校支持的功能列表");
    });
    Route::group(['namespace' => 'Util', 'prefix' => 'util'], function () {
        Route::get('provinceList', 'PositionController@getProvince')->name("获取省份列表");
        Route::get('cityList/{province_id}', 'PositionController@getCity')->name("获取城市列表");
        Route::get('districtList/{city_id}', 'PositionController@getDistrict')->name("获取地区列表");
        Route::get('universityList/{district_id}', 'PositionController@getUniversity')->name("获取学校列表");
    });
});

