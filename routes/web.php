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

Route::get('/{vue_route}', 'EventCreatorController@index')->where('vue_route', '[\/\w\.-]*');;

// Auth::routes();

// Route::get('/home', 'EventCreatorController@index')->name('home');

// Route::post('/save-event', 'EventCreatorController@store')->name('event.store');
// Route::get('/get-event/{id}', 'EventCreatorController@show')->name('event.get');
// Route::get('/get-event', 'EventCreatorController@getLatest')->name('event.getlatest');

