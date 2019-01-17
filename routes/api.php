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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('search', 'SearchController@search');

    Route::get('/user', 'UserController@getUser');

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::post('settings/profile/photo', 'Settings\ProfileController@updatePhoto');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::get('/last', 'GlobalController@getLast');

    Route::prefix('streams')->group(function () {
        Route::get('all', 'StreamController@all');
        Route::get('online', 'StreamController@online');
        Route::get('lastonline', 'StreamController@lastonline');
        Route::get('tag/{tag}', 'StreamController@byTag');
        Route::get('tags/{twitchname}', 'StreamController@tags');
        Route::get('/{slug}', 'StreamController@bySlug');
    });

    Route::prefix('articles')->group(function () {
        Route::get('all', 'ArticleController@all');
        Route::get('paginate', 'ArticleController@paginate');
        Route::get('/{slug}', 'ArticleController@byAuthorSlug');
        Route::get('/{author}/{slug}', 'ArticleController@bySlug');
    });

    Route::prefix('videos')->group(function () {
        Route::get('paginate', 'VideoController@paginate');
        Route::get('/{slug}', 'VideoController@byChannelSlug');
        Route::get('/{channel}/{slug}', 'VideoController@bySlug');
    });

    Route::prefix('podcasts')->group(function () {
        Route::get('paginate', 'PodcastController@paginate');
        Route::get('/{slug}', 'PodcastController@byShowSlug');
        Route::get('/{show}/{slug}', 'PodcastController@bySlug');
    });

    Route::prefix('bookmark')->group(function () {
        Route::post('toggle', 'BookmarkController@toggle');
        Route::post('type', 'BookmarkController@byType');
        Route::get('user', 'BookmarkController@forUser');
    });

    Route::prefix('suggestion')->group(function () {
        Route::post('add', 'SuggestionController@add');
    });
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('stats', 'StatsController@base');
    Route::post('early-access', 'Auth\EarlyAccessController@store');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
