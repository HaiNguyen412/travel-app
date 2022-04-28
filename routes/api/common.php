<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => '',
    'middleware' => [],
    'prefix' => '/',
    'as' => '.',
], function () {
    // todo: need for adding middleware JWT here
    Route::group([
        'namespace' => 'Api',
        'middleware' => [],
        'prefix' => '/images',
        'as' => 'images.',
    ], function () {
        Route::post('/single', 'ImageController@upload')->name('upload');
//        Route::post('/multi', 'ImageController@upload')->name('upload_multiple');
    });
});




