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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::get('/threads/create', 'ThreadsController@create');
Route::post('/threads', 'ThreadsController@store');

// Route::resource('/threads', 'ThreadsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
