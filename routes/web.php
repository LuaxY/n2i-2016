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

Route::get('/login', 'UserController@login_form')->name('login');
Route::post('/login', 'UserController@login')->name('login');
Route::get('/register', 'UserController@create')->name('register');
Route::post('/register', 'UserController@store')->name('register');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'FormationController@all')->name('home');
    Route::get('/logout', 'UserController@logout')->name('logout');
    Route::get('/formation', 'FormationController@all')->name('formation.list');
    Route::get('/formation/{formationId}', 'FormationController@view')->name('formation.view');
    Route::get('/formation/{formationId}/forum', 'CommentController@formation')->name('formation.forum');
    Route::post('/formation/{formationId}/forum', 'CommentController@store_formation')->name('formation.forum');
    Route::get('/formation/{formationId}/page/{pageId}', 'PageController@view')->name('page.view');
    Route::get('/formation/{formationId}/page/{pageId}/forum', 'CommentController@page')->name('page.forum');
    Route::post('/formation/{formationId}/page/{pageId}/forum', 'CommentController@store_page')->name('page.forum');
    Route::post('/search', 'FormationController@search')->name('search');
});


Route::get('/test', function(){ return view('formation.view');});