<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\NewPasswordController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\EmailVerificationController;
use Illuminate\Http\Request;
use App\Models\User;

Route::group([
    'namespace' => 'Api\V1',
    'middleware' => [],
    'prefix' => 'v1',
    'as' => 'v1.',
], function () {
    Route::post('users/{user}/update-password', 'UserController@updatePassword')->name('users.update_password');
    Route::post('users/update_avatar', 'UserController@updateAvatar')->name('users.update_avatar');
    Route::get('users/listadmin', 'UserController@listAdmin')->name('users.listadmin');
    Route::apiResource('users', 'UserController');
    Route::get('roles', 'RoleController@index')->name('roles.index');
    Route::get('positions', 'PositionController@index')->name('positions.index');
    Route::get('priorities', 'PriorityController@index')->name('priorities.index');

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('logout', 'AuthController@logout')->name('logout');
        Route::get('me', 'AuthController@me')->name('me');
    });

    Route::post('email/verification-notification', 'EmailVerificationController@sendVerificationEmail');

    Route::post('/login/{provider}/process', 'AuthController@loginSocialHandle')->name('login_social_handle');
    Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
    Route::post('reset-password', [NewPasswordController::class, 'reset']);

    Route::post('/editprofile',[UserController::class,'updateProfile']);

    Route::get('categories/list', 'CategoryController@list')->name('categories.list');
    Route::apiResource('categories', 'CategoryController');

    Route::post('requests/status/{request}', 'RequestController@updateStatus')->name('requests.update_status');
    Route::post('requests/{request}/approve', 'RequestController@approve')->name('requests.approve');
    Route::post('requests/{request}/reject', 'RequestController@reject')->name('requests.reject');
    Route::post('requests/history', 'RequestController@history')->name('requests.history');
    Route::apiResource('requests', 'RequestController');

    Route::get('my_request', 'RequestController@myRequest')->name('requests.myrequest');
    Route::post('my_request/{request}', 'RequestController@comment')->name('requests.comment');

    Route::get('department/list', 'DepartmentController@list')->name('department.list');
    Route::apiResource('department', 'DepartmentController');

});



