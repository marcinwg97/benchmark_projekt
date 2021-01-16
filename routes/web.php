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

Route::get('/', 'HomeController@index')->name('welcome');

Route::post('/benchmark', 'BenchmarkController@benchmark')->name('benchmark');

Auth::routes();

Route::get('/panel', 'UserController@index');

Route::post('/panel', 'UserController@store')->name('panel.store');