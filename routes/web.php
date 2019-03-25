<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('/', 'SQSController',['names'=>[
    'create' => 'send.queue',

    Route::get('/receive', [
        'as' => 'receive.queue',
        'uses' => 'SQSController@receive',
    ]),
    Route::get('/addtopic', [
        'as' => 'add.topic',
        'uses' => 'SQSController@addTopic',
    ]),
]]);
