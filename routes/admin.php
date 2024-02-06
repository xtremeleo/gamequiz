<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', 'Admin\HomeController@index')->name('admin.index');

//Users
Route::get('/admin/users', 'Admin\UsersController@index')->name('admin.users');
Route::get('/admin/users/{id}/profile', 'Admin\UsersController@profile')->name('admin.users.profile');
Route::get('/admin/users/action', 'Admin\UsersController@index');
Route::post('/admin/users/action', 'Admin\UsersController@action')->name('admin.users.action');

//Games
Route::get('/admin/games', 'Admin\GamesController@index')->name('admin.games');
Route::get('/admin/games/new', 'Admin\GamesController@create')->name('admin.games.new');
Route::get('/admin/games/details', 'Admin\GamesController@details')->name('admin.games.details');
Route::get('/admin/games/questions', 'Admin\GamesController@questions')->name('admin.games.questions');
Route::get('/admin/games/action', 'Admin\GamesController@index');
Route::post('/admin/games/action', 'Admin\GamesController@action')->name('admin.games.action');
