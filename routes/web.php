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

Route::get('/twitch/update/{twitch_id}', 'TwitchController@subscribe')->name('twitch.subscribe');
Route::post('/twitch/update/{twitch_id}', 'TwitchController@update')->name('twitch.update');
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('{path}', 'GlobalController@index')->where('path', '(.*)');
