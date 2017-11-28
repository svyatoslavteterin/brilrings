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

      if ($base!=6) continue;


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

  $weights=\App\RingOptionValue::where('enabled','=',1)->where('ring_option_id','=',7)->get();









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

Route::get('/weight_size_map',function(){
  return Redis::get('weight_size_map');

});
Route::get('/generateprice',function(){

  $shape=1;
  $stone=1;
  $weight=1;
  $color=1;

  /*
    $price_map[1][1][1][1]=499;
    $price_map[1][1][1][2]=420;
    $price_map[1][1][1][3]=360;
    $price_map[1][1][1][4]=300;

    $price_map[1][1][2][1]=650;
    $price_map[1][1][2][2]=540;
    $price_map[1][1][2][3]=450;
    $price_map[1][1][2][4]=360;

    $price_map[1][1][3][1]=790;
    $price_map[1][1][3][2]=604;
    $price_map[1][1][3][3]=520;
    $price_map[1][1][3][4]=460;

    $price_map[1][1][4][1]=860;
    $price_map[1][1][4][2]=680;
    $price_map[1][1][4][3]=600;
    $price_map[1][1][4][4]=530;

    $price_map[1][1][5][1]=1140;
    $price_map[1][1][5][2]=780;
    $price_map[1][1][5][3]=700;
    $price_map[1][1][5][4]=620;

    $price_map[1][1][6][1]=1200;
    $price_map[1][1][6][2]=900;
    $price_map[1][1][6][3]=800;
    $price_map[1][1][6][4]=760;

    $price_map[1][1][7][1]=1500;
    $price_map[1][1][7][2]=1110;
    $price_map[1][1][7][3]=1020;
    $price_map[1][1][7][4]=860;

    $price_map[1][1][8][1]=1750;
    $price_map[1][1][8][2]=1430;
    $price_map[1][1][8][3]=1300;
    $price_map[1][1][8][4]=1170;

    $price_map[1][1][9][1]=2150;
    $price_map[1][1][9][2]=1550;
    $price_map[1][1][9][3]=1400;
    $price_map[1][1][9][4]=1090;

    $price_map[1][1][10][1]=2550;
    $price_map[1][1][10][2]=1800;
    $price_map[1][1][10][3]=1550;
    $price_map[1][1][10][4]=1180;

    $price_map[1][1][11][1]=3150;
    $price_map[1][1][11][2]=2150;
    $price_map[1][1][11][3]=1900;
    $price_map[1][1][11][4]=1400;

    $price_map[1][1][12][1]=3450;
    $price_map[1][1][12][2]=2300;
    $price_map[1][1][12][3]=2000;
    $price_map[1][1][12][4]=1550;

    $price_map[1][1][13][1]=4050;
    $price_map[1][1][13][2]=2800;
    $price_map[1][1][13][3]=2450;
    $price_map[1][1][13][4]=1790;

    $price_map[1][1][14][1]=1500;
    $price_map[1][1][14][2]=1110;
    $price_map[1][1][14][3]=1020;
    $price_map[1][1][14][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;

    $price_map[1][1][6][1]=1500;
    $price_map[1][1][6][2]=1110;
    $price_map[1][1][6][3]=1020;
    $price_map[1][1][6][4]=860;
      */

      $prices[1]=array(499,420,360,300,650,540,450,360,790,604,520,460,860,680,600,530,1140,780,700,620,1200,900,800,760,1500,1110,1020,860,1750,1430,1300,1170,2150,1550,1400,1090,2550,1800,1550,1180,3150,2150,1900,1400,3450,2300,2000,1550,4050,2800,2450,1790,5350,3100,2650,2000,6050,4300,3550,2500,7050,3800,3250,2200,8850,5300,4750,3200,11000,5350,5000,3750,11500,6850,5800,4000,12500,8050,6200,4050,13500,8350,6700,4450,15500,8650,7300,4550,16500,9350,7700,5100,17500,9650,8100,5200,18500,10350,8500,5750,19500,11350,9100,5850,21000,13850,10100,6250,21500,13850,10300,6430,21500,15850,11000,7550,25200,16050,11300,7650,27500,16550,12300,8250,24500,16250,12600,8250,28300,16850,13300,9750,30000,19050,14300,9850,34000,23150,15300,11250,35500,23350,18300,11250,35500,25350,19100,11750,40500,26350,19300,12250);

      $prices[2]=array(499,420,360,300,650,540,450,360,790,604,520,460,860,680,600,530,1140,780,700,620,1200,900,800,760,1500,1110,1020,860,1750,1430,1300,1170,2150,1550,1400,1090,2550,1800,1550,1180,3150,2150,1900,1400,3450,2300,2000,1550,4050,2800,2450,1790,5350,3100,2650,2000,6050,4300,3550,2500,7050,3800,3250,2200,8850,5300,4750,3200,11000,5350,5000,3750,11500,6850,5800,4000,12500,8050,6200,4050,13500,8350,6700,4450,15500,8650,7300,4550,16500,9350,7700,5100,17500,9650,8100,5200,18500,10350,8500,5750,19500,11350,9100,5850,21000,13850,10100,6250,21500,13850,10300,6430,21500,15850,11000,7550,25200,16050,11300,7650,27500,16550,12300,8250,24500,16250,12600,8250,28300,16850,13300,9750,30000,19050,14300,9850,34000,23150,15300,11250,35500,23350,18300,11250,35500,25350,19100,11750,40500,26350,19300,12250);


      $prices[3]=array(
        499,420,360,300,650,540,450,360,790,604,520,460,860,680,600,530,1140,780,700,620,1200,900,800,760,1500,1110,1020,860,1750,1430,1300,1170,2150,1550,1400,1090,2550,1800,1550,1180,3150,2150,1900,1400,3450,2300,2000,1550,4050,2800,2450,1790,5350,3100,2650,2000,6050,4300,3550,2500,7050,3800,3250,2200,8850,5300,4750,3200,11000,5350,5000,3750,11500,6850,5800,4000,12500,8050,6200,4050,13500,8350,6700,4450,15500,8650,7300,4550,16500,9350,7700,5100,17500,9650,8100,5200,18500,10350,8500,5750,19500,11350,9100,5850,21000,13850,10100,6250,21500,13850,10300,6430,21500,15850,11000,7550,25200,16050,11300,7650,27500,16550,12300,8250,24500,16250,12600,8250,28300,16850,13300,9750,30000,19050,14300,9850,34000,23150,15300,11250,35500,23350,18300,11250,35500,25350,19100,11750,40500,26350,19300,12250
      );

      $prices[4]=array(499,420,360,300,650,540,450,360,790,604,520,460,860,680,600,530,1140,780,700,620,1200,900,800,760,1500,1110,1020,860,1750,1430,1300,1170,2150,1550,1400,1090,2550,1800,1550,1180,3150,2150,1900,1400,3450,2300,2000,1550,4050,2800,2450,1790,5350,3100,2650,2000,6050,4300,3550,2500,7050,3800,3250,2200,8850,5300,4750,3200,11000,5350,5000,3750,11500,6850,5800,4000,12500,8050,6200,4050,13500,8350,6700,4450,15500,8650,7300,4550,16500,9350,7700,5100,17500,9650,8100,5200,18500,10350,8500,5750,19500,11350,9100,5850,21000,13850,10100,6250,21500,13850,10300,6430,21500,15850,11000,7550,25200,16050,11300,7650,27500,16550,12300,8250,24500,16250,12600,8250,28300,16850,13300,9750,30000,19050,14300,9850,34000,23150,15300,11250,35500,23350,18300,11250,35500,25350,19100,11750,40500,26350,19300,12250);

$prices[5]=array(499,420,360,300,650,540,450,360,790,604,520,460,860,680,600,530,1140,780,700,620,1200,900,800,760,1500,1110,1020,860,1750,1430,1300,1170,2150,1550,1400,1090,2550,1800,1550,1180,3150,2150,1900,1400,3450,2300,2000,1550,4050,2800,2450,1790,5350,3100,2650,2000,6050,4300,3550,2500,7050,3800,3250,2200,8850,5300,4750,3200,11000,5350,5000,3750,11500,6850,5800,4000,12500,8050,6200,4050,13500,8350,6700,4450,15500,8650,7300,4550,16500,9350,7700,5100,17500,9650,8100,5200,18500,10350,8500,5750,19500,11350,9100,5850,21000,13850,10100,6250,21500,13850,10300,6430,21500,15850,11000,7550,25200,16050,11300,7650,27500,16550,12300,8250,24500,16250,12600,8250,28300,16850,13300,9750,30000,19050,14300,9850,34000,23150,15300,11250,35500,23350,18300,11250,35500,25350,19100,11750,40500,26350,19300,12250
);

$prices[6]=array(499,420,360,300,650,540,450,360,790,604,520,460,860,680,600,530,1140,780,700,620,1200,900,800,760,1500,1110,1020,860,1750,1430,1300,1170,2150,1550,1400,1090,2550,1800,1550,1180,3150,2150,1900,1400,3450,2300,2000,1550,4050,2800,2450,1790,5350,3100,2650,2000,6050,4300,3550,2500,7050,3800,3250,2200,8850,5300,4750,3200,11000,5350,5000,3750,11500,6850,5800,4000,12500,8050,6200,4050,13500,8350,6700,4450,15500,8650,7300,4550,16500,9350,7700,5100,17500,9650,8100,5200,18500,10350,8500,5750,19500,11350,9100,5850,21000,13850,10100,6250,21500,13850,10300,6430,21500,15850,11000,7550,25200,16050,11300,7650,27500,16550,12300,8250,24500,16250,12600,8250,28300,16850,13300,9750,30000,19050,14300,9850,34000,23150,15300,11250,35500,23350,18300,11250,35500,25350,19100,11750,40500,26350,19300,12250);

$prices[7]=array(499,420,360,300,650,540,450,360,790,604,520,460,860,680,600,530,1140,780,700,620,1200,900,800,760,1500,1110,1020,860,1750,1430,1300,1170,2150,1550,1400,1090,2550,1800,1550,1180,3150,2150,1900,1400,3450,2300,2000,1550,4050,2800,2450,1790,5350,3100,2650,2000,6050,4300,3550,2500,7050,3800,3250,2200,8850,5300,4750,3200,11000,5350,5000,3750,11500,6850,5800,4000,12500,8050,6200,4050,13500,8350,6700,4450,15500,8650,7300,4550,16500,9350,7700,5100,17500,9650,8100,5200,18500,10350,8500,5750,19500,11350,9100,5850,21000,13850,10100,6250,21500,13850,10300,6430,21500,15850,11000,7550,25200,16050,11300,7650,27500,16550,12300,8250,24500,16250,12600,8250,28300,16850,13300,9750,30000,19050,14300,9850,34000,23150,15300,11250,35500,23350,18300,11250,35500,25350,19100,11750,40500,26350,19300,12250
);
$prices[8]=array(499,420,360,300,650,540,450,360,790,604,520,460,860,680,600,530,1140,780,700,620,1200,900,800,760,1500,1110,1020,860,1750,1430,1300,1170,2150,1550,1400,1090,2550,1800,1550,1180,3150,2150,1900,1400,3450,2300,2000,1550,4050,2800,2450,1790,5350,3100,2650,2000,6050,4300,3550,2500,7050,3800,3250,2200,8850,5300,4750,3200,11000,5350,5000,3750,11500,6850,5800,4000,12500,8050,6200,4050,13500,8350,6700,4450,15500,8650,7300,4550,16500,9350,7700,5100,17500,9650,8100,5200,18500,10350,8500,5750,19500,11350,9100,5850,21000,13850,10100,6250,21500,13850,10300,6430,21500,15850,11000,7550,25200,16050,11300,7650,27500,16550,12300,8250,24500,16250,12600,8250,28300,16850,13300,9750,30000,19050,14300,9850,34000,23150,15300,11250,35500,23350,18300,11250,35500,25350,19100,11750,40500,26350,19300,12250
);



      $weights=\App\RingOptionValue::where('enabled','=',1)->where('ring_option_id','=',7)->get();


      $weight_aliases=array();
      foreach ($weights->toArray() as $weight_arr){


        $weight_aliases[$weight_arr['title']]=$weight_arr['value'];

      }
        $weight_aliases["1"]=  $weight_aliases['1.0'];
        $weight_aliases["2"]=  $weight_aliases['2.0'];



      $weight_step=0.05;



      $stone=1;

      $color_step=1;

      for ($shape=1;$shape<8;$shape++){
        $weight=0.15;
        $color=1;

      for ($i=0;$i<=count($prices[$shape])-1;$i++){

          if ($i%4==0 && $i!=0) {
             $color=1;
            $weight+=$weight_step;
           }

           $price_map[$shape][$stone][$weight_aliases["$weight"]][$color]=$prices[$shape][$i];
        $color+=$color_step;



      }

    }

    echo "<pre>";
   print_r($price_map);die;
    echo "</pre>";


    $stone_price_map=json_decode(\Redis::get('stone_price_map'));

    print_r($stone_price_map);die;
  //  Redis::set('stone_price_map', json_encode($price_map));
});
Route::get('/generate',function(){

  $weights=\App\RingOptionValue::where('enabled','=',1)->where('ring_option_id','=',7)->get();


  $weight_aliases=array();
  foreach ($weights->toArray() as $weight_arr){


    $weight_aliases[$weight_arr['title']]=$weight_arr['value'];

  }



  $sizes=\App\RingOptionValue::where('ring_option_id','=',6)->get();


  $size_aliases=array();
  foreach ($sizes->toArray() as $size_arr){


    $size_aliases[$size_arr['title']]=$size_arr['value'];

  }


  $weight_size_map=new \StdClass();
  $weight_size_map->aliases=array();

  $aliases["0.15"]=3.5;
  $aliases["0.2"]=3.75;
  $aliases["0.25"]=4;
  $aliases["0.3"]=4.3;
  $aliases["0.35"]=4.5;
  $aliases["0.4"]=4.7;
  $aliases["0.45"]=4.8;
  $aliases["0.5"]=5;
  $aliases["0.55"]=5.2;
  $aliases["0.6"]=5.3;
  $aliases["0.65"]=5.4;
  $aliases["0.7"]=5.5;
  $aliases["0.75"]=5.6;
  $aliases["0.8"]=5.7;
  $aliases["0.85"]=5.8;
  $aliases["0.9"]=5.9;
  $aliases["0.95"]=6;
  $aliases["1.0"]=6.3;
  $aliases["1.05"]=6.4;
  $aliases["1.1"]=6.5;
  $aliases["1.2"]=6.7;
  $aliases["1.25"]=6.8;
  $aliases["1.3"]=6.9;
  $aliases["1.35"]=7;
  $aliases["1.4"]=7.1;
  $aliases["1.45"]=7.2;
  $aliases["1.5"]=7.5;
  $aliases["1.55"]=7.6;
  $aliases["1.6"]=7.7;
  $aliases["1.65"]=7.8;
  $aliases["1.7"]=7.9;
  $aliases["1.75"]=8;
  $aliases["1.8"]=8.05;
  $aliases["1.85"]=8.1;
  $aliases["1.9"]=8.15;
  $aliases["1.95"]=8.2;
  $aliases["2.0"]=8.25;


foreach ($aliases as $weight_title=>$size_title){
  $weight_size_map->aliases["$weight_aliases[$weight_title]"]=$size_aliases["$size_title"];
}


Redis::set('weight_size_map', json_encode($weight_size_map));die;
//$test=json_decode(Redis::get('weight_size_map'));
print_r($test);die;

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
