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

Route::get('/', 'EmployeesController@index');

Route::get('/employees/{employee}/subtree', 'EmployeesController@subtree');

Route::get('/employees/get-bosses', 'EmployeesController@getBosses')->middleware('auth');

Route::get('/employees', 'EmployeesController@showList')->middleware('auth');

Route::post('/employees', 'EmployeesController@store')->middleware('auth');

Route::get('/employees/create', 'EmployeesController@create')->middleware('auth');

Route::get('/employees/{employee}/edit', 'EmployeesController@edit')->middleware('auth');

Route::patch('/employees/{employee}', 'EmployeesController@update')->middleware('auth');

Route::delete('/employees/{employee}', 'EmployeesController@destroy')->middleware('auth');

Auth::routes();

