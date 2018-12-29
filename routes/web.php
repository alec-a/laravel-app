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






Route::get('dashboard','dashboardController@index');

route::resource('farms','farmController')->only(['index','store']);
Route::resource('farm','farmController')->except(['index','store']);
Route::put('farm/join/{farm}','farmController@join');
Route::put('farm/leave/{farm}','farmController@leave');

Route::delete('/fields/{fields}', 'fieldsController@destroy');

Route::resource('ajax/field','fieldsController')->parameters(['field' => 'fields']);

Route::resource('farm/{farm}/worklogs','worklogController')->only(['index','store']);
Route::resource('farm/{farm}/worklog','worklogController')->except(['index','store']);
Route::post('ajax/farm/{farm}/worklogs', 'worklogController@index');
Route::post('ajax/farm/{farm}/worklogs/store', 'worklogController@store');
Route::post('ajax/farm/{farm}/worklog/edit', 'worklogController@edit');
Route::post('ajax/farm/{farm}/worklog/create', 'worklogController@create');
Route::post('ajax/farm/{farm}/worklog/{worklog}', 'worklogController@show');
Route::resource('ajax/farm/{farm}/worklog','worklogController')->except(['index','store','edit','create']);

Route::resource('farm/{farm}/worklog/{worklog}/fields','worklogFieldController')->only(['index','store'])->parameters(['field' => 'worklogField']);
Route::resource('farm/{farm}/worklog/{worklog}/field','worklogFieldController')->except(['index','store'])->parameters(['field' => 'worklogField']);
Route::resource('ajax/farm/{farm}/worklog/{worklog}/fields','worklogFieldController')->only(['index','store'])->parameters(['field' => 'worklogField']);
Route::resource('ajax/farm/{farm}/worklog/{worklog}/field','worklogFieldController')->except(['index','store'])->parameters(['field' => 'worklogField']);


Route::resource('farm/{farm}/worklog/{worklog}/field/{worklogField}/tasks','worklogTaskController')->only(['index','store']);
Route::resource('farm/{farm}/worklog/{worklog}/field/{worklogField}/tasks','worklogTaskController')->except(['index','store']);
Route::resource('ajax/farm/{farm}/worklog/{worklog}/field/{worklogField}/tasks','worklogTaskController')->only(['index','store']);
Route::resource('ajax/farm/{farm}/worklog/{worklog}/field/{worklogField}/task','worklogTaskController')->except(['index','store']);

Route::resource('tasks','taskController')->only(['index','store']);
Route::resource('task','taskController')->except(['index','store']);
Route::resource('ajax/tasks','taskController')->only(['index','store']);
Route::resource('ajax/task','taskController')->except(['index','store']);

Route::resource('issue', 'issueController');

Route::post('ajax/modal','modalController@get');
Route::post('ajax/modal/farms','modalController@farms');
Route::post('ajax/modal/fields','modalController@field');

route::group(array('prefix' => 'account'), function(){
	Route::get('register/confirmed','Auth\RegisterController@confirmed');
	Auth::routes();
});

Route::resource('account','userController')->parameters(['account' => 'user']);

Route::get('/{uri?}/{uri1?}/{uri2?}', 'pageController@show');

