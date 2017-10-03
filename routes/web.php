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

Route::get('/ring_sessions','RingSessionController@index');

Route::get('/ring_options','RingOptionController@index');

Route::get('/ring_option_values','RingOptionValueController@index');


Route::get('/', function () {

  $tasks=DB::table('tasks')->get();

    return view('welcome',compact('tasks'));
});
