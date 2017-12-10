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

Route::get('/resultimage/{base}/{material}/{shape}/{weight}/','RingImageController@getResultImg');
Route::get('/baseimages/{base}/{material}/{size}','RingImageController@getBaseImg');
Route::get('/baseimages/{base}/{material}/{size}/{shape}','RingImageController@getBaseImg');

Route::get('/ringimages/{size}/{hash}.jpg','RingImageController@getImage');








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
      $file['file']=$value.'/1.jpg';
      $file['bok_file']=$value.'/bok.jpg';

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

            $img_bok=  $import_dir.'/'.$base.'/';
          if ($params['shape']>1 || $params['weight']>1){



              if ($params['material']>1){
                $img_bok.="m".$params['material'].'/';
              }

          }
          $img_bok.='bok.jpg';

          $file['bok_file']=$img_bok;

          $file['params']=$params;
          $file['file']=$img.'/1.jpg';;
          $Files[]=$file;
          $i++;

      } // folders with modif

    } // folders with base


    foreach ($Files as $file) {


      $hash=App\RingOption::getHash($file['params']);

      $filename=$hash.'.jpg';

      $readfile=$file['bok_file'];

      if ( File::exists($readfile))  {
        $img = Image::make($readfile);
      //  $img->save('./images/rings/'.$filename);
        $img->save('./images/rings/bok/'.$filename);
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





          if ($base<5) continue;

          $shapes=File::directories($base_value);

          $bok_image_index=array_search($import_dir.'/'.$material_value.'/'.$base.'/'.'_BOK',$shapes);
          $bok_images=File::files($shapes[$bok_image_index]);
          $bok_image= Image::make($bok_images[0]);

          unset($shapes[$bok_image_index]);


          foreach ($shapes as $shape_value){
            $weight=array();


            $shape=$shape_aliases[strtolower(str_replace(array($import_dir,'/',$base,$material_value),'',$shape_value))]; // shape

              if ($shape!=1) continue;

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


                //$img->save($path.'/1.jpg');

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
              $path_bok='';
              $path_bok.='./import-files/images/';
              $path_bok.=$base.'/';
                if ($material>1){
                  $path_bok.="m".$material;
                }
                if (!file_exists(  $path_bok)) {
                  mkdir($path_bok, 0777, true);

                  }
              $bok_image->save($path_bok.'/bok.jpg');

            Redis::set('ring_params_map:'.$base, json_encode($rings_params_map));
        }
    }

  }


});

Route::get('/', function () {


    return view('constructor/index');
});

Route::get('/for-her', function () {

    $pagetitle='Подарок для нее';
    return view('pages/for-her',compact('pagetitle'));
});

Route::get('/about', function () {

    $pagetitle='О нас';
    return view('pages/about-us',compact('pagetitle'));
});

Route::get('/contacts', function () {

    $pagetitle='Контакты';

    return view('pages/contacts',compact('pagetitle'));
});


Route::get('/constructor/{step}/{base}/{material}/{shape}/{weight}/{color}/{stone}','ConstructorController@history');



Route::get('/constructor/base/{base}/{material}','ConstructorController@index');

Route::get('/constructor/base/{base}/{material}/{shape}/{weight}/{color}/{stone}','ConstructorController@history');

Route::get('/constructor/base', function () {

    $ring_options=json_encode(\App\RingOption::all()->toArray());

    return view('constructor/base',['ring_options'=>$ring_options]);
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


      $prices[1]=array(899,470,410,350,1050,590,500,410,1190,654,570,510,1175,689,650,580,1570,930,750,610,1650,1012,913,658,1690,1160,1030,910,2137,1433,1293,1129,2750,1700,1550,1240,2863,1810,1700,1330,3060,2300,2050,1550,3173,2500,2406,1891,4700,2950,2600,1940,5877,3261,2800,2150,5900,3750,3700,2650,6200,4087,3400,2750,7000,5210,4900,2850,8100,5567,5202,3154,9400,7000,5950,4150,10025,7100,6350,4200,10400,7239,6850,4600,10840,7418,7250,4700,11067,8390,7850,5250,12000,8876,8250,5350,12600,10500,8650,5900,12900,11500,9250,6300,13300,14000,10010,7000,13886,11615,10318,7513,14000,12480,11350,7700,15400,12800,12150,7800,15900,14300,13349,8500,16300,15200,13927,8928,17499,15700,14416,9150,17616,16170,14805,9300,20070,16499,15430,9500,24950,16800,15750,12400,28500,17200,16010,13450,31400,17846,16265,14447);

      $prices[2]=array(899,470,410,350,1050,590,500,410,1190,654,570,510,1260,800,720,543,1300,830,750,670,1373,937,822,701,1900,1160,1080,910,2335,1477,1352,1213,2700,1850,1565,1340,2500,2033,1684,1400,2690,2250,2100,1650,2839,2153,2181,1563,4600,2549,2500,2040,5900,2768,2653,2096,6600,4550,3060,2200,7965,3382,3252,2227,8500,4220,4100,2680,11080,4383,4291,2847,11100,5200,4350,4150,11300,5371,4450,4200,11800,8500,5950,4600,12100,6369,6228,4849,12800,7083,6250,5160,14000,7251,6350,5200,16100,7400,7150,5900,18600,7711,7454,6290,21600,10300,8240,6850,22100,11024,10348,7431,23100,13950,10450,7500,24300,14900,10650,7630,28100,16300,12059,7900,25100,16500,13445,8000,28900,17500,14320,8200,30600,19200,16650,8400,34600,19600,17450,9200,36100,20000,18450,9984,36100,20500,19250,11300,41100,21500,21073,11816);



      $prices[3]=array(
        1570,930,750,610,1650,1012,913,658,1690,1160,1030,910,2137,1433,1293,1129,2750,1700,1550,1240,2863,1810,1700,1330,3060,2300,2050,1550,3173,2500,2406,1891,4700,2950,2600,1940,5877,3261,2800,2150,5900,3750,3700,2650,6200,4087,3400,2750,7000,5210,4900,2850,8100,5567,5202,3154,9400,7000,5950,4150,10025,7100,6350,4200,10400,7239,6850,4600,10840,7418,7250,4700,11067,8390,7850,5250,12000,8876,8250,5350,12600,10500,8650,5900,12900,11500,9250,6300,13300,14000,10010,7000,13886,11615,10318,7513,14000,12480,11350,7700,15400,12800,12150,7800,15900,14300,13349,8500,16300,15200,13927,8928,17499,15700,14416,9150,17616,16170,14805,9300,20070,16499,15430,9500,24950,16800,15750,12400,28500,17200,16010,13450,31400,17846,16265,14447
      );



      $prices[4]=array(  899,470,410,350,1050,590,500,410,1190,654,570,510,1260,730,650,570,1540,830,750,660,1600,966,880,800,1900,1170,1049,900,2624,1563,1333,1155,2800,1662,1400,1240,2900,1918,1511,1300,3000,1990,1655,1505,3233,2120,1817,1662,4555,2906,2245,1900,4999,3239,2403,2139,5200,3449,2756,2610,5670,3695,3079,2695,5999,4017,3210,2917,7158,4370,3487,3079,7440,4690,3799,3189,8733,4950,4206,3365,10177,5490,4451,3400,10944,7100,4796,3568,11950,7700,5107,3794,13499,9050,5448,4101,14190,10370,5930,4398,15199,11500,6338,4638,16280,14000,6743,5071,17270,15500,7107,5578,17800,16400,7420,6590,18200,16600,7770,6992,18780,16840,8140,7500,19849,17600,8380,8785,20611,18360,8790,8969,22249,18730,9319,9294,22790,19500,9695,9533,23280,19845,10237,9850,24370,20255,11128,10170,25499,20725,12200,10573);


$prices[5]=array(499,420,360,300,650,540,450,360,790,604,520,460,869,680,600,495,937,780,700,580,1400,907,777,614,1500,1110,1020,860,1610,1459,1315,1035,2110,1650,1400,1090,2186,1890,1700,1180,3150,2150,1900,1204,3350,2373,1965,1343,4650,2800,2350,1690,5790,3136,2483,1782,6050,3700,2920,2090,7050,4032,3149,2213,7850,4890,3850,2760,8600,5312,4240,3038,9500,5800,4600,4000,9897,6114,5104,4050,13500,6450,5300,4249,15500,6850,5448,4252,16500,7280,6900,5100,17500,7830,7200,5200,18500,8316,7600,5350,19500,9351,8400,5550,21000,9745,8745,5720,28250,9818,9187,5981,29000,12250,9530,6550,29730,13149,9800,7150,30500,14130,10170,7450,31500,14971,10413,7799,32200,17850,11500,9750,32900,18850,13199,9850,34000,19050,13800,11850,35500,19550,14400,12830,36400,20150,15079,14050,36988,20828,15470,14950
);



$prices[6]=array(899,470,410,350,989,570,511,410,1145,663,528,440,1207,716,577,455,1487,792,650,597,1549,935,835,649,1711,1077,909,910,2309,1650,1493,1067,2616,1623,1600,1182,2644,1866,1670,1266,3100,2050,1993,1550,3590,2650,2472,1762,3900,3250,2761,1940,3970,3300,2800,2109,4600,3550,3050,2600,5124,3888,3233,2801,7000,5950,5276,3130,8764,6268,5437,3336,8800,6290,5450,4150,9855,6400,5950,4305,10100,7000,6450,4600,11047,8434,6750,5095,13000,9000,7850,5250,13741,9300,8858,5400,13920,10000,8650,5900,15500,10700,9250,6000,16000,11300,10250,7000,17411,11797,10563,7465,19565,12000,11150,8329,19888,12500,11566,8985,19950,13200,12450,9050,20000,13500,12450,9200,22497,14698,12550,9900,23811,17500,13950,10000,24000,19400,14450,11181,24187,20569,14959,11400,27286,24500,19467,11900,30067,27940,23750,12126);


$prices[7]=array(899,470,410,350,1050,590,500,410,1190,654,570,510,1260,730,650,580,1540,830,750,670,1600,950,850,810,1800,1160,1070,910,2200,1550,1450,1100,2397,1700,1550,1150,3200,1950,1700,1200,3800,2300,1950,1340,4100,2498,2100,1547,4700,2850,2344,1940,5800,3050,2400,2150,6000,3199,2600,2300,6200,3850,2767,2482,6500,4350,3100,2550,7400,4988,3750,2734,10900,5400,4177,3150,11800,5700,4750,3380,12500,6060,5550,3500,13211,6204,6250,3802,15000,7100,6650,4800,15500,7600,7350,5080,16300,8400,7950,5399,16900,9491,8750,5500,18000,10500,8950,6000,19100,11620,9280,6146,20500,12400,9450,6400,23300,13000,9650,6800,24700,13600,9950,7200,25500,14300,10150,7900,27100,15400,10450,8300,28566,16100,11650,8700,33388,16400,12350,9270,34600,17000,13340,9834,35550,25500,13950,10300,39300,26500,14760,10800
);



$prices[8]=array(899,470,410,350,1050,590,500,410,1190,700,250,510,1260,836,650,580,1387,900,250,670,1821,950,250,810,1890,1160,250,910,2350,1580,1450,1320,2800,1700,1550,1240,3200,1950,1700,1330,3800,2300,2050,1550,4100,2755,2150,1700,4700,2950,2600,1940,5700,3250,2800,2150,6400,4450,3700,2650,6681,5940,3400,2350,8900,6250,4900,3350,11700,7100,5600,4300,12579,7500,6400,4550,14000,8700,6800,4600,15000,9000,7300,5000,17000,9300,7900,5100,18000,10000,8300,5650,19000,10300,8700,5750,20000,11000,9100,6300,21000,12000,9700,6400,22500,14500,10700,6800,23000,14500,10900,6980,23000,16500,11600,8100,26700,16700,11900,8200,29000,17200,12900,8800,26000,16900,13200,8800,29800,17500,13900,10300,2000,19700,14900,10400,2000,23800,15900,11800,2000,1000,18900,11800,2000,1000,900,800,2000,1000,900,800
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

      for ($shape=1;$shape<=8;$shape++){
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

    $mussanit_prices[1]["0.15"]=115;
    $mussanit_prices[1]["0.25"]=132;
    $mussanit_prices[1]["0.35"]=149;
    $mussanit_prices[1]["0.5"]=203;
    $mussanit_prices[1]["0.7"]=221;
    $mussanit_prices[1]["0.95"]=245;
    $mussanit_prices[1]["1.1"]=330;
    $mussanit_prices[1]["1.35"]=339;
    $mussanit_prices[1]["1.5"]=469;
    $mussanit_prices[1]["1.75"]=546;
    $mussanit_prices[1]["2.0"]=633;

    $mussanit_prices[2]["0.15"]=115;
    $mussanit_prices[2]["0.25"]=132;
    $mussanit_prices[2]["0.35"]=149;

    $mussanit_prices[2]["0.7"]=221;
    $mussanit_prices[2]["0.95"]=245;
    $mussanit_prices[2]["1.1"]=330;
    $mussanit_prices[2]["1.25"]=245;
    $mussanit_prices[2]["1.35"]=339;
    $mussanit_prices[2]["1.5"]=469;
    $mussanit_prices[2]["1.75"]=546;
    $mussanit_prices[2]["2.0"]=633;

    $mussanit_prices[3]["0.15"]=115;
    $mussanit_prices[3]["0.25"]=132;
    $mussanit_prices[3]["0.35"]=149;

    $mussanit_prices[3]["0.5"]=203;

    $mussanit_prices[3]["0.7"]=221;

    $mussanit_prices[3]["0.95"]=245;
    $mussanit_prices[3]["1.1"]=330;
    $mussanit_prices[3]["1.35"]=389;
    $mussanit_prices[3]["1.5"]=469;
    $mussanit_prices[3]["1.75"]=546;
    $mussanit_prices[3]["2.0"]=633;


  $mussanit_prices[4]["0.15"]=115;
  $mussanit_prices[4]["0.25"]=132;
  $mussanit_prices[4]["0.35"]=149;
  $mussanit_prices[4]["0.5"]=203;
  $mussanit_prices[4]["0.7"]=221;
  $mussanit_prices[4]["0.95"]=245;
  $mussanit_prices[4]["1.1"]=330;
  $mussanit_prices[4]["1.35"]=389;
  $mussanit_prices[4]["1.5"]=469;
  $mussanit_prices[4]["1.75"]=546;
  $mussanit_prices[4]["2.0"]=633;

  $mussanit_prices[5]["0.25"]=132;
  $mussanit_prices[5]["0.35"]=149;
  $mussanit_prices[5]["0.5"]=203;
  $mussanit_prices[5]["0.7"]=221;
  $mussanit_prices[5]["0.95"]=245;
  $mussanit_prices[5]["1.1"]=330;
  $mussanit_prices[5]["1.35"]=389;
  $mussanit_prices[5]["1.75"]=546;
  $mussanit_prices[5]["2.0"]=633;

  $mussanit_prices[6]["0.15"]=115;
  $mussanit_prices[6]["0.25"]=132;
  $mussanit_prices[6]["0.35"]=149;
  $mussanit_prices[6]["0.5"]=203;
  $mussanit_prices[6]["0.7"]=221;
  $mussanit_prices[6]["0.95"]=245;
  $mussanit_prices[6]["1.1"]=330;
  $mussanit_prices[6]["1.35"]=389;
  $mussanit_prices[6]["1.5"]=469;
  $mussanit_prices[6]["1.75"]=546;
  $mussanit_prices[6]["2.0"]=633;

  $mussanit_prices[7]["0.15"]=115;
  $mussanit_prices[7]["0.25"]=132;
  $mussanit_prices[7]["0.35"]=149;
  $mussanit_prices[7]["0.5"]=203;
  $mussanit_prices[7]["0.7"]=221;
  $mussanit_prices[7]["0.95"]=245;
  $mussanit_prices[7]["1.1"]=330;
  $mussanit_prices[7]["1.35"]=389;
  $mussanit_prices[7]["1.5"]=469;
  $mussanit_prices[7]["1.75"]=546;
  $mussanit_prices[7]["2.0"]=633;


  $mussanit_prices[8]["0.15"]=115;
  $mussanit_prices[8]["0.25"]=132;
  $mussanit_prices[8]["0.35"]=149;
  $mussanit_prices[8]["0.5"]=203;
  $mussanit_prices[8]["0.7"]=221;
  $mussanit_prices[8]["0.95"]=245;
  $mussanit_prices[8]["1.1"]=330;
  $mussanit_prices[8]["1.35"]=389;
  $mussanit_prices[8]["1.5"]=469;
  $mussanit_prices[8]["1.75"]=546;
  $mussanit_prices[8]["2.0"]=633;



$stone=2;
$color=3;
  for ($shape=1;$shape<=8;$shape++){
    foreach ($mussanit_prices[$shape] as $weight=>$price){
      for ($color=1;$color<=4;$color++){
       $price_map[$shape][$stone][$weight_aliases["$weight"]][$color]=$mussanit_prices[$shape]["$weight"];
      }
    }

}




    echo "<pre>";
   print_r($price_map);
    echo "</pre>";


    //$stone_price_map=json_decode(\Redis::get('stone_price_map'));

    //print_r($stone_price_map);die;
   Redis::set('stone_price_map', json_encode($price_map));
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



Route::post('/savetoemail','ConstructorController@savetoemail');

Route::post('/call-order','ConstructorController@callorder');
Route::post('/help-order','ConstructorController@helporder');
Route::post('/guest-order','ConstructorController@guestorder');
