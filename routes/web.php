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


Route::get('/contacts', 'ContactsController@index')->name('contacts');
Route::get('/contacts/create', 'ContactsController@create')->name('contacts@create');
Route::post('/contacts/store', 'ContactsController@store')->name('contacts@store');
Route::get('/contacts/{id}/edit', 'ContactsController@edit')->name('contacts@edit');
Route::put('/contacts/{id}/update', 'ContactsController@update')->name('contacts@update');
Route::delete('/contacts/{id}/destroy', 'ContactsController@destroy')->name('contacts@destroy');

Route::get('/tasks', 'TasksController@index')->name('tasks');