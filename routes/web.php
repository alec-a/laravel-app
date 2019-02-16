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
Route::get('dashboard/modalDev','modalController@index');
/*farm*/
route::resource('farms','farmController')->only(['index','store']);
Route::resource('farm','farmController')->except(['index','store']);
Route::post('ajax/farm/{farm}','farmController@show');
Route::get('farm/{farm}/next-season','farmController@nextSeason');
Route::post('ajax/farm/{farm}/next-season','farmController@nextSeason');
Route::put('farm/join/{farm}','farmController@join');
Route::put('farm/leave/{farm}','farmController@leave');


/*Field*/
Route::delete('/fields/{fields}', 'fieldsController@destroy');
Route::resource('ajax/field','fieldsController')->parameters(['field' => 'fields'])->only(['update','store']);
Route::post('ajax/fields/','fieldsController@index');
Route::delete('ajax/fields/trash','fieldsController@trash');
Route::delete('ajax/fields/delete','fieldsController@delete');
Route::put('ajax/fields/restore','fieldsController@restore');
/*worklog */
Route::resource('farm/{farm}/worklogs','worklogController')->only(['index','store']);
Route::resource('farm/{farm}/worklog','worklogController')->except(['index','store']);
Route::post('ajax/farm/{farm}/worklogs', 'worklogController@index');
Route::post('ajax/farm/{farm}/worklogs/store', 'worklogController@store');
Route::post('ajax/farm/{farm}/worklog/edit', 'worklogController@edit');
Route::post('ajax/farm/{farm}/worklog/create', 'worklogController@create');
Route::post('ajax/farm/{farm}/worklog/{worklog}', 'worklogController@show');
Route::resource('ajax/farm/{farm}/worklog','worklogController')->except(['index','store','edit','create']);
Route::delete('ajax/farm/{farm}/worklog/{worklog}/trash', 'worklogController@trash');
Route::delete('ajax/farm/{farm}/worklog/{worklog}/delete', 'worklogController@destroy');
Route::put('ajax/farm/{farm}/worklog/{worklog}/restore', 'worklogController@restore');


Route::resource('farm/{farm}/worklog/{worklog}/fields','worklogFieldController')->only(['index','store'])->parameters(['field' => 'worklogField']);
Route::resource('farm/{farm}/worklog/{worklog}/field','worklogFieldController')->except(['index','store'])->parameters(['field' => 'worklogField']);
Route::resource('ajax/farm/{farm}/worklog/{worklog}/fields','worklogFieldController')->only(['index','store'])->parameters(['field' => 'worklogField']);
Route::resource('ajax/farm/{farm}/worklog/{worklog}/field','worklogFieldController')->except(['index','store'])->parameters(['field' => 'worklogField']);

Route::post('ajax/farm/{farm}/farmTask/store', 'farmTaskController@store');
Route::post('ajax/farm/{farm}/farmTasks', 'farmTaskController@index');
Route::put('ajax/farm/{farm}/farmTask/{farmTask}', 'farmTaskController@update');
Route::delete('ajax/farm/{farm}/farmTask/{farmTask}/trash', 'farmTaskController@trash');
Route::delete('ajax/farm/{farm}/farmTask/{farmTask}/delete', 'farmTaskController@destroy');
Route::put('ajax/farm/{farm}/farmTask/{farmTask}/restore', 'farmTaskController@restore');

/* Worklog Task*/

Route::post('ajax/farm/{farm}/task', 'worklogTaskController@index');
Route::post('ajax/farm/{farm}/task/store', 'worklogTaskController@store');
Route::post('ajax/farm/{farm}/task/edit', 'worklogTaskController@edit');
Route::post('ajax/farm/{farm}/task/create', 'worklogTaskController@create');
Route::post('ajax/farm/{farm}/task/{worklogTask}', 'worklogTaskController@show');
Route::resource('ajax/farm/{farm}/task','worklogTaskController')->parameters(['task' => 'worklogTask'])->except(['index','store','edit','create']);

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
Route::post('ajax/modal/applications','modalController@applications');

route::group(array('prefix' => 'account'), function(){
	Route::get('register/confirmed','Auth\RegisterController@confirmed');
	Auth::routes();
});

Route::resource('account','userController')->parameters(['account' => 'user']);




/* Applications */
route::resource('applications','applicationController');
route::put('ajax/application/{user}','applicationController@update');
route::post('ajax/applications','applicationController@allForStatus');
route::delete('ajax/applications','applicationController@destroy');

/* Front End Controller */
Route::get('/{uri?}/{uri1?}/{uri2?}', 'pageController@show');

