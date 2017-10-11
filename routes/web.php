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


Route::get('/ring_options/{ring_option}','RingOptionController@show');

Route::get('/ring_options','RingOptionController@get');
Route::get('/ring_options/{ring_option}/values','RingOptionController@getValues');




Route::get('/ring_option_values','RingOptionValueController@get');
Route::get('/ring_option_values/{option}','RingOptionValueController@index');

Route::get('/ring_sessions/create',function(){return view('sessions/create');});


Route::get('/', function () {


  /*

    $ring_options=App\RingOption::all()->where('parent_id',0);

    $output=new StdClass();

    foreach ($ring_options as $ring_option){


      $output->{$ring_option->key}=$ring_option->children;
    }

    $ring_options=$output;
    */



    return view('constructor/index');
});


Route::post('/ring_sessions','RingSessionController@create');
