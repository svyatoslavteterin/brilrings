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

Route::get('/resultimage/{hash}/','RingImageController@getResultImg');



Route::get('/ring_option_values','RingOptionValueController@get');
Route::get('/ring_option_values/{option}','RingOptionValueController@index');

Route::get('/ring_sessions/create',function(){return view('sessions/create');});
Route::get('/import',function(){

    $import_dir='./import-files/images';
    $list = File::directories($import_dir);
    $options=App\RingOption::all()->toArray();
    $params=array();

    $aliases=array(
      's'=>'size',
      'm'=>'material',
      'sh'=>'shape',
      'w'=>'weight'
    );

    


    $Files=array();

    foreach ($options as $key=>$param){
      $params[$param['key']]=1;
    }

    function init(&$arr){
      foreach ($arr as $key=>$row){
        $arr[$key]=1;
      }

      return $arr;
    }

    foreach ($list as $key=>$value){

      $base=str_replace(array($import_dir,'/'),'',$value);
      $params['base']=$base;

      $imgs=File::directories($value);
      $i=0;

      $file['params']=$params;
      $file['file']=$value;
      $Files[]=$file;

      foreach ($imgs as $img){


        init($params);
        $params['base']=$base;

        $modif=str_replace(array($value,'/'),'',$img);
        $change_params=explode("-",$modif);

        foreach ($change_params as $change_param){
          $newvalue=preg_replace("/[^0-9]/","",$change_param);
          $param_key=preg_replace("/[^a-zA-Z]/","",$change_param);

          // Set new value for param
          $params[$aliases[$param_key]]=$newvalue;



        }// loop modifs

          $file=array();
          $file['params']=$params;
          $file['file']=$img;
          $Files[]=$file;
          $i++;

      } // folders with modif

    } // folders with base





    foreach ($Files as $file) {


      $hash=App\RingOption::getHash($file['params']);

      $filename=$hash.'.jpg';

      $readfile=$file['file'].'/1.jpg';

      if ( File::exists($readfile))  {
        $img = Image::make($readfile);
        $img->save('./images/rings/'.$filename);
      }

    }

//  $img = Image::make('public/foo.jpg');


//  $img->save('public/bar.jpg');
});




Route::get('/', function () {


    return view('constructor/index');
});


Route::post('/ring_sessions','RingSessionController@create');
