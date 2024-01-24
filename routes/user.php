<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', 'User\HomeController@index')->name('dashboard');

//Verification
Route::get('/verify/{id}/{code}', 'Auth\VerificationController@index');
Route::get('/verify/bank/{id}/{account}/{code}/{res}', 'Auth\VerificationController@bank_account')->name('verify.bank')->middleware('auth');
Route::get('/verify/withdraw/{user_id}/{wlrt_id}/{code}/{res}', 'Auth\VerificationController@withdraw')->name('verify.withdraw')->middleware('auth');
Route::get('/verify/needed', 'Auth\VerificationController@needed')->name('verify.needed')->middleware('auth');
Route::get('/verify/send', 'Auth\VerificationController@send')->name('verify.send')->middleware('auth');

//Game Sectionsend
Route::get('/game', 'User\GameController@index')->name('game');
Route::get('/game/past', 'User\GameController@past')->name('game.past');
Route::get('/game/{id}', 'User\GameController@start_game')->name('game.start');
Route::get('/game/ended/{id}', 'User\GameController@ended_game')->name('game.ended');
Route::post('/game/{id}', 'User\GameController@submit')->name('game.submit');


//Wallet
Route::get('/wallet', 'User\WalletController@index')->name('wallet');
Route::post('/wallet', 'User\WalletController@action')->name('wallet.action');
Route::get('/wallet/fund', 'User\WalletController@fund')->name('wallet.fund');
Route::get('/wallet/withdraw', 'User\WalletController@withdraw')->name('wallet.withdraw');
Route::get('/wallet/verify/{id}/transaction', 'User\WalletController@verify')->name('wallet.verify.transaction');

//Account
Route::get('/account', 'User\AccountController@index')->name('account');
Route::get('/account/activities', 'User\AccountController@activities')->name('account.activities');
Route::get('/account/bank', 'User\AccountController@bank')->name('account.bank');
Route::post('/account', 'User\AccountController@action')->name('account.action');
Route::get('/account/details/edit', 'User\AccountController@details_edit')->name('account.details.edit');

