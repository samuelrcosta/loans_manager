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

Auth::routes(['register' => false, 'password.email' => false, 'password.request' => false, 'password.update' => false, 'password.reset ' => false]);
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/alerts', 'AlertsController@index')->name('alerts');
Route::post('/alerts/subscription', 'AlertsController@storeSubscription')->name('alerts@storeSubscription');
Route::delete('/alerts/subscription', 'AlertsController@destroySubscription')->name('alerts@destroySubscription');
Route::get('/alerts/create/{task_id?}', 'AlertsController@create')->name('alerts@create');
Route::get('/alerts/{id}/edit', 'AlertsController@edit')->name('alerts@edit');
Route::post('/alerts/{id}/editStatus', 'AlertsController@updateStatus')->name('alerts@updateStatus');
Route::post('/alerts', 'AlertsController@store')->name('alerts@store');
Route::put('/alerts/{id}', 'AlertsController@update')->name('alerts@update');
Route::delete('/alerts/{id}', 'AlertsController@destroy')->name('alerts@destroy');

Route::get('/contacts', 'ContactsController@index')->name('contacts');
Route::get('/contacts/create', 'ContactsController@create')->name('contacts@create');
Route::post('/contacts/store', 'ContactsController@store')->name('contacts@store');
Route::get('/contacts/{id}/edit', 'ContactsController@edit')->name('contacts@edit');
Route::put('/contacts/{id}', 'ContactsController@update')->name('contacts@update');
Route::delete('/contacts/{id}', 'ContactsController@destroy')->name('contacts@destroy');

Route::get('/tasks', 'TasksController@index')->name('tasks');
Route::get('/tasks/create', 'TasksController@create')->name('tasks@create');
Route::get('/tasks/{id}/edit', 'TasksController@edit')->name('tasks@edit');
Route::post('/tasks', 'TasksController@store')->name('tasks@store');
Route::post('/tasks/{id}/editStatus', 'TasksController@updateStatus')->name('tasks@updateStatus');
Route::get('/tasks/{id}', 'TasksController@show')->name('tasks@show');
Route::put('/tasks/{id}', 'TasksController@update')->name('tasks@update');
Route::delete('/tasks/{id}', 'TasksController@destroy')->name('tasks@destroy');

Route::get('/tasks/{task_id}/entries/create', 'EntriesController@create')->name('entries@create');
Route::get('/tasks/{task_id}/entries/{id}/edit', 'EntriesController@edit')->name('entries@edit');
Route::post('/tasks/{task_id}/entries', 'EntriesController@store')->name('entries@store');
Route::put('/tasks/{task_id}/entries/{id}', 'EntriesController@update')->name('entries@update');
Route::delete('/tasks/{task_id}/entries/{id}', 'EntriesController@destroy')->name('entries@destroy');

Route::get('/notifications', 'NotificationsController@index')->name('notifications');