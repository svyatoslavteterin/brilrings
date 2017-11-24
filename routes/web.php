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
set_time_limit(200);
Route::get('/ring_sessions','RingSessionController@index');


Route::get('/ring_options/{ring_option}','RingOptionController@show');

Route::get('/ring_options','RingOptionController@get');
Route::get('/ring_options/{ring_option}/values','RingOptionController@getValues');

Route::get('/resultimage/{base}/{material}/{shape}/{weight}/{hash}/','RingImageController@getResultImg');
Route::get('/baseimages/{base}/{material}/{size}','RingImageController@getBaseImg');
Route::get('/baseimages/{base}/{material}/{size}/{shape}','RingImageController@getBaseImg');




Route::get('/ring_option_values','RingOptionValueController@get');
Route::get('/ring_option_values/{option}','RingOptionValueController@index');

Route::get('/ring_sessions/create',function(){return view('sessions/create');});
Route::get('/import-images',function(){

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

      if ($base!=7) continue;


      init($params);
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

///*** PREPARE STEP:  sort images for import to system

Route::get('/sort-images',function(){

  $import_dir='./import-files/sort-images';
  $list = File::directories($import_dir);

  $material_aliases=array(
    'Rose'=>array(6),
    'White'=>array(1,2,3,7),
    'Yellow'=>array(4,5)
  );
  $shape_aliases=array(
    'round'=>1,
    'princess'=>2,
    'oval'=>3,
    'asscher'=>4,
    'heart'=>5,
    'pear'=>6,
    'cushion'=>7,
    'emerald'=>8
  );

  $weights=\App\RingOptionValue::where('ring_option_id','=',7)->get();









$weight_aliases=array();
  foreach ($weights->toArray() as $weight_arr){


    $weight_aliases[$weight_arr['title']]=$weight_arr['value'];

  }



  foreach ($list as $key=>$value){

    $material_value=str_replace(array($import_dir,'/'),'',$value);

    $d=$material_aliases[$material_value];

    foreach ($d as $material){ //material


        $bases=File::directories($value);


        foreach ($bases as $base_value){


          $base=str_replace(array($import_dir,'/',$material_value),'',$base_value); //base

          if ( $rings_params_map = json_decode(Redis::get('ring_params_map:'.$base))) {

          }else{
            $rings_params_map=new \StdClass();

          }





          if ($base!=12) continue;

          $shapes=File::directories($base_value);

          $bok_image_index=array_search($import_dir.'/'.$material_value.'/'.$base.'/'.'_BOK',$shapes);
          unset($shapes[$bok_image_index]);


          foreach ($shapes as $shape_value){
            $weight=array();


            $shape=$shape_aliases[strtolower(str_replace(array($import_dir,'/',$base,$material_value),'',$shape_value))]; // shape

              if ($shape<4) continue;

            $imgs=File::files($shape_value);

                $weights=array();

            foreach ($imgs as $img){
              $img_name=$img->getRelativePathname();
              $img_name_arr=explode('_',$img_name);
              $weight_value=str_replace('.jpg','',$img_name_arr[2]);
              $weight_value=str_replace(',','.',  $weight_value);
              $weight=$weight_aliases[$weight_value]; //weight

              $readfile=$shape_value.'/'.$img_name;



              if ( File::exists($readfile))  {

                $img = Image::make($readfile);
                if (!file_exists('./import-files/images/'.$base)) {
                    mkdir('./import-files/images/'.$base, 0777, true);
                }
                //
                $path='';
                $params=array();
                $path.='./import-files/images/';
                $path.=$base.'/';
                if ($material>1){
                  $params[]='m'.$material;
                }
                if ($shape>1){
                  $params[]='sh'.$shape;
                }
                if ($weight>1){
                  $params[]='w'.$weight;
                }

                $path.=implode('-',$params);


                  if (!file_exists(  $path)) {
                    mkdir($path, 0777, true);

              }

                $img->save($path.'/1.jpg');

                $weights[]=$weight_value;


              }



            }

              if (isset(  $rings_params_map->shapes)){


              }else{
                $rings_params_map->shapes=new \StdClass;
              }

            asort($weights);
            $weights= array_values($weights);
                $rings_params_map->shapes->{$shape}=$weights;





          }

            Redis::set('ring_params_map:'.$base, json_encode($rings_params_map));
        }
    }

  }


});

Route::get('/', function () {


    return view('constructor/index');
});
Route::get('/constructor/base/{base}/{material}','ConstructorController@index');

Route::get('/constructor/base', function () {


    return view('constructor/base');
});


Route::get('/getprice/{shape}/{size}/{color}/{clarity}/','ConstructorController@getprice');


Route::get('/generate',function(){

  $base=12;
  $weight=3;
  $shape=1;
/*
  $rings_params_map=new \StdClass();
  $rings_params_map->{$base}=new \StdClass();


  $rings_params_map->{$base}->shapes[1]=array(0.15,0.25,0.5,0.75,1.0,1.5,2.0);
  $rings_params_map->{$base}->shapes[2]=array(0.15,0.25,0.5,0.75,1.0,1.5,2.0);
  $rings_params_map->{$base}->shapes[3]=array(0.15,0.25,0.5,0.75,1.0,1.5,2.0);
  $rings_params_map->{$base}->shapes[4]=array(0.15,0.25,0.5,0.75,1.0,1.5,2.0);
  $rings_params_map->{$base}->shapes[5]=array(0.15,0.25,0.5,0.75,1.0,1.5,2.0);
  $rings_params_map->{$base}->shapes[6]=array(0.15,0.25,0.5,0.75,1.0,1.5,2.0);
  $rings_params_map->{$base}->shapes[7]=array(0.15,0.25,0.5,0.75,1.0,1.5,2.0);
  $rings_params_map->{$base}->shapes[8]=array(0.15,0.25,0.5,0.75,1.0,1.5,2.0);
*/


//Redis::set('ring_params_map:'.$base, '');die;


   $rings_params_map = json_decode(Redis::get('ring_params_map:'.$base));
   echo "<pre>";
   print_r($rings_params_map); echo "</pre>";die;

if (isset($rings_params_map->shapes->{$shape})){ // If we have ring with such base and shape
  $sizes=$rings_params_map->shapes->{$shape};
    //**** Count delta from shape and next shape in sizes set
    $i=0;
    $choose_size=$sizes[$i];
      while(abs($sizes[$i]-$weight)>abs($sizes[$i+1]-$weight) ){

          $choose_size=$sizes[$i+1];
          $i++;
          if ($i+1==count($sizes)) break;
      }

      if ($i==count($sizes))   $choose_size=$sizes[$i-1];
      echo $choose_size;
      die;

}


die;

  /*$value=8;
  for ($i=0.22;$i<=2;$i+=0.01){
    $optionvalue = new \App\ringOptionValue;

  $optionvalue->ring_option_id=7;
  $optionvalue->value=$value;
  $optionvalue->title=round($i,2);
  $optionvalue->price=0;
  $optionvalue->desc='';

    $optionvalue->save();

    $value++;

  }

  die;
  */
});

Route::get('/constructor/stone', function () {


    return view('constructor/stone');
});


Route::post('/ring_sessions','RingSessionController@create');
