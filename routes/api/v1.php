<?php

use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\NewPasswordController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

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
    Route::apiResource('categories', 'CategoryController');
    Route::apiResource('blogs', 'BlogController');
    Route::post('/like/{id}',[BlogController::class,'like']);
    Route::post('/dislike/{id}',[BlogController::class,'dislike']);


});




