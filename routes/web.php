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

Route::get('/', 'FormationController@list')->name('home');
Route::get('/login', 'UserController@login_form')->name('login');
Route::post('/login', 'UserController@login')->name('login');
Route::get('/logout', 'UserController@logout')->name('logout');
