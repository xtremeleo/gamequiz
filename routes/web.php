<?php

use Illuminate\Support\Facades\Route;

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

//~ Route::get('/', function () {
    //~ return view('welcome');
//~ })->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/p/{person}', 'HomeController@promote')->name('home.promote');
Route::get('/about', 'HomeController@about')->name('home.about');
Route::get('/privacy', 'HomeController@contact')->name('home.privacy');
Route::get('/contact', 'HomeController@contact')->name('home.contact');

//TestQuiz
Route::get('/test/quiz/', 'TestQuizController@index')->name('test.quiz');//->middleware('auth');
Route::post('/test/quiz/', 'TestQuizController@action')->name('test.action');//->middleware('auth');

Route::get('/join/{id}', 'JoinController@index')->name('join');//->middleware('auth');
Route::get('/join/closed/{id}', 'JoinController@closed')->name('join.closed');//->middleware('auth');
Route::get('/join/success/{id}', 'JoinController@success')->name('join.success');//->middleware('auth');
Route::post('/join/{id}', 'JoinController@action')->name('join.action');//->middleware('auth');

Auth::routes();

//~ Route::get('/blackops/{subject}', 'HomeController@blackops');
Route::get('/blackops', 'HomeController@blackops');
