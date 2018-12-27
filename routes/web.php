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


//Route::get('/{uri}', function($uri){ dd($uri);});





Route::group(array('prefix' => 'dashboard'), function(){
		Route::get('/','dashboardController@index');
		
});

Route::resource('farms','farmController');
Route::put('farms/join/{farm}','farmController@join');
Route::put('farms/leave/{farm}','farmController@leave');

Route::resource('ajax/field','fieldsController')->parameters(['field' => 'fields']);

Route::post('ajax/modal','modalController@get');
Route::post('ajax/modal/farms','modalController@farms');
Route::post('ajax/modal/fields','modalController@field');


route::group(array('prefix' => 'account'), function(){
	Route::get('register/confirmed','Auth\RegisterController@confirmed');
	Auth::routes();
});

Route::resource('account','userController')->parameters(['account' => 'user']);

Route::get('/{uri?}/{uri1?}/{uri2?}', 'pageController@show');

