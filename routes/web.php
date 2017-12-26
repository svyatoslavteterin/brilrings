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


      $prices[1]=array(53940,25200,21600,18000,63000,32400,27000,21600,71400,36240,31200,27600,100548,54264,47880,42294,122892,62244,55860,49476,127680,71820,63840,60648,151620,88578,81396,68628,183540,122094,111720,101346,215460,131670,119700,94962,247380,151620,131670,102144,295260,179550,159600,119700,319200,191520,167580,131670,367080,231420,203490,150822,470820,255360,219450,167580,526680,351120,291270,207480,606480,311220,267330,183540,750120,430920,387030,263340,917700,434910,406980,307230,957600,554610,470820,327180,1037400,650370,502740,331170,1117200,674310,542640,363090,1276800,698250,590520,371070,1356600,754110,622440,414960,1436400,778050,654360,422940,1516200,833910,686280,466830,1596000,913710,734160,474810,1715700,1113210,813960,506730,1755600,1113210,829920,521094,1755600,1272810,885780,610470,2050860,1288770,909720,618450,2234400,1328670,989520,666330,1995000,1304730,1013460,666330,2298240,1352610,1069320,786030,2433900,1528170,1149120,794010,2753100,1855350,1228920,905730,2872800,1871310,1468320,905730,2872800,2030910,1532160,945630,3271800,2110710,1548120,985530);


      $prices[2]=array(53940,28200,24600,21000,63000,35400,30000,24600,71400,39240,34200,30600,75600,48000,43200,32580,103740,66234,59850,53466,109565.4,74772.6,65595.6,55939.8,151620,92568,86184,72618,186333,117864.6,107889.6,96797.4,215460,147630,124887,106932,199500,162233.4,134383.2,111720,214662,179550,167580,131670,226552.2,171809.4,174043.8,124727.4,367080,203410.2,199500,162792,470820,220886.4,211709.4,167260.8,526680,363090,244188,175560,635607,269883.6,259509.6,177714.6,678300,336756,327180,213864,884184,349763.4,342421.8,227190.6,885780,414960,347130,331170,901740,428605.8,355110,335160,941640,678300,474810,367080,965580,508246.2,496994.4,386950.2,1021440,565223.4,498750,411768,1117200,578629.8,506730,414960,1284780,590520,570570,470820,1484280,615337.8,594829.2,501942,1723680,821940,657552,546630,1763580,879715.2,825770.4,592993.8,1843380,1113210,833910,598500,1939140,1189020,849870,608874,2242380,1300740,962308.2,630420,2002980,1316700,1072911,638400,2306220,1396500,1142736,654360,2441880,1532160,1328670,670320,2761080,1564080,1392510,734160,2880780,1596000,1472310,796723.2,2880780,1635900,1536150,901740,3279780,1715700,1681625.4,942916.8);



      $prices[3]=array(
      53940,28200,24600,21000,63000,35400,30000,24600,71400,39240,34200,30600,93765,54982.2,51870,46284,125286,74214,59850,48678,131670,80757.6,72857.4,52508.4,134862,92568,82194,72618,170532.6,114353.4,103181.4,90094.2,219450,135660,123690,98952,228467.4,144438,135660,106134,244188,183540,163590,123690,253205.4,199500,191998.8,150901.8,375060,235410,207480,154812,468984.6,260227.8,223440,171570,470820,299250,295260,211470,494760,326142.6,271320,219450,558600,415758,391020,227430,646380,444246.6,415119.6,251689.2,750120,558600,474810,331170,799995,566580,506730,335160,829920,577672.2,546630,367080,865032,591956.4,578550,375060,883146.6,669522,626430,418950,957600,708304.8,658350,426930,1005480,837900,690270,470820,1029420,917700,738150,502740,1061340,1117200,798798,558600,1108102.8,926877,823376.4,599537.4,1117200,995904,905730,614460,1228920,1021440,969570,622440,1268820,1141140,1065250.2,678300,1300740,1212960,1111374.6,712454.4,1396420.2,1252860,1150396.8,730170,1405756.8,1290366,1181439,742140,1601586,1316620.2,1231314,758100,1991010,1340640,1256850,989520,2274300,1372560,1277598,1073310,2505720,1424110.8,1297947,1152870.6
      );



      $prices[4]=array(  53940,28200,24600,21000,63000,35400,30000,24600,71400,39240,34200,30600,100548,58254,51870,45486,122892,66234,59850,52668,127680,77086.8,70224,63840,151620,93366,83710.2,71820,209395.2,124727.4,106373.4,92169,223440,132627.6,111720,98952,231420,153056.4,120577.8,103740,239400,158802,132069,120099,257993.4,169176,144996.6,132627.6,363489,231898.8,179151,151620,398920.2,258472.2,191759.4,170692.2,414960,275230.2,219928.8,208278,452466,294861,245704.2,215061,478720.2,320556.6,256158,232776.6,571208.4,348726,278262.6,245704.2,593712,374262,303160.2,254482.2,696893.4,395010,335638.8,268527,812124.6,438102,355189.8,271320,873331.2,566580,382720.8,284726.4,953610,614460,407538.6,302761.2,1077220.2,722190,434750.4,327259.8,1132362,827526,473214,350960.4,1212880.2,917700,505772.4,370112.4,1299144,1117200,538091.4,404665.8,1378146,1236900,567138.6,445124.4,1420440,1308720,592116,525882,1452360,1324680,620046,557961.6,1498644,1343832,649572,598500,1583950.2,1404480,668724,701043,1644757.8,1465128,701442,715726.2,1775470.2,1494654,743656.2,741661.2,1818642,1556100,773661,760733.4,1857744,1583631,816912.6,786030,1944726,1616349,888014.4,811566,2034820.2,1653855,973560,843725.4);



$prices[5]=array(29940,25200,21600,18000,39000,32400,27000,21600,47400,36240,31200,27600,52140,40800,36000,29700,56220,46800,42000,34800,84000,54420,46620,36840,90000,66600,61200,51600,96600,87540,78900,62100,126600,99000,84000,65400,131160,113400,102000,70800,189000,129000,114000,72240,201000,142380,117900,80580,279000,168000,141000,101400,347400,188160,148980,106920,363000,222000,175200,125400,423000,241920,188940,132780,471000,293400,231000,165600,516000,318720,254400,182280,570000,348000,276000,240000,593820,366840,306240,243000,810000,387000,318000,254940,930000,411000,326880,255120,990000,436800,414000,306000,1050000,469800,432000,312000,1110000,498960,456000,321000,1170000,561060,504000,333000,1260000,584700,524700,343200,1695000,589080,551220,358860,1740000,735000,571800,393000,1783800,788940,588000,429000,1830000,847800,610200,447000,1890000,898260,624780,467940,1932000,1071000,690000,585000,1974000,1131000,791940,591000,2040000,1143000,828000,711000,2130000,1173000,864000,769800,2184000,1209000,904740,843000,2219280,1249680,928200,897000
);



$prices[6]=array(53940,28200,24600,21000,59340,34200,30660,24600,68700,39780,31680,26400,96318.6,57136.8,46044.6,36309,118662.6,63201.6,51870,47640.6,123610.2,74613,66633,51790.2,136537.8,85944.6,72538.2,72618,184258.2,131670,119141.4,85146.6,208756.8,129515.4,127680,94323.6,210991.2,148906.8,133266,101026.8,247380,163590,159041.4,123690,286482,211470,197265.6,140607.6,311220,259350,220327.8,154812,316806,263340,223440,168298.2,367080,283290,243390,207480,408895.2,310262.4,257993.4,223519.8,558600,474810,421024.8,249774,699367.2,500186.4,433872.6,266212.8,702240,501942,434910,331170,786429,510720,474810,343539,805980,558600,514710,367080,881550.6,673033.2,538650,406581,1037400,718200,626430,418950,1096531.8,742140,706868.4,430920,1110816,798000,690270,470820,1236900,853860,738150,478800,1276800,901740,817950,558600,1389397.8,941400.6,842927.4,595707,1561287,957600,889770,664654.2,1587062.4,997500,922966.8,717003,1592010,1053360,993510,722190,1596000,1077300,993510,734160,1795260.6,1172900.4,1001490,790020,1900117.8,1396500,1113210,798000,1915200,1548120,1153110,892243.8,1930122.6,1641406.2,1193728.2,909720,2177422.8,1955100,1553466.6,949620,2399346.6,2229612,1895250,967654.8);




$prices[7]=array(53940,28200,24600,21000,63000,35400,30000,24600,71400,39240,34200,30600,100548,58254,51870,46284,122892,66234,59850,53466,127680,75810,67830,64638,143640,92568,85386,72618,175560,123690,115710,87780,191280.6,135660,123690,91770,255360,155610,135660,95760,303240,183540,155610,106932,327180,199340.4,167580,123450.6,375060,227430,187051.2,154812,462840,243390,191520,171570,478800,255280.2,207480,183540,494760,307230,220806.6,198063.6,518700,347130,247380,203490,590520,398042.4,299250,218173.2,869820,430920,333324.6,251370,941640,454860,379050,269724,997500,483588,442890,279300,1054237.8,495079.2,498750,303399.6,1197000,566580,530670,383040,1236900,606480,586530,405384,1300740,670320,634410,430840.2,1348620,757381.8,698250,438900,1436400,837900,714210,478800,1524180,927276,740544,490450.8,1635900,989520,754110,510720,1859340,1037400,770070,542640,1971060,1085280,794010,574560,2034900,1141140,809970,630420,2162580,1228920,833910,662340,2279566.8,1284780,929670,694260,2664362.4,1308720,985530,739746,2761080,1356600,1064532,784753.2,2836890,2034900,1113210,821940,3136140,2114700,1177848,861840
);



$prices[8]=array(53940,28200,24600,21000,63000,35400,30000,24600,71400,42000,15000,30600,100548,66712.8,51870,46284,110682.6,71820,19950,53466,145315.8,75810,19950,64638,150822,92568,19950,72618,187530,126084,115710,105336,223440,135660,123690,98952,255360,155610,135660,106134,303240,183540,163590,123690,327180,219849,171570,135660,375060,235410,207480,154812,454860,259350,223440,171570,510720,355110,295260,211470,533143.8,474012,271320,187530,710220,498750,391020,267330,933660,566580,446880,343140,1003804.2,598500,510720,363090,1117200,694260,542640,367080,1197000,718200,582540,399000,1356600,742140,630420,406980,1436400,798000,662340,450870,1516200,821940,694260,458850,1596000,877800,726180,502740,1675800,957600,774060,510720,1795500,1157100,853860,542640,1835400,1157100,869820,557004,1835400,1316700,925680,646380,2130660,1332660,949620,654360,2314200,1372560,1029420,702240,2074800,1348620,1053360,702240,2378040,1396500,1109220,821940,159600,1572060,1189020,829920,159600,1899240,1268820,941640,159600,79800,1508220,941640,159600,79800,71820,63840,159600,79800,71820,63840
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

    $mussanit_prices[1]["0.15"]=6924;
    $mussanit_prices[1]["0.25"]=7928;
    $mussanit_prices[1]["0.35"]=8974;
    $mussanit_prices[1]["0.5"]=12228;
    $mussanit_prices[1]["0.7"]=13274;
    $mussanit_prices[1]["0.95"]=14738;
    $mussanit_prices[1]["1.1"]=19829;
    $mussanit_prices[1]["1.35"]=23385;
    $mussanit_prices[1]["1.5"]=28195;
    $mussanit_prices[1]["1.75"]=32796;
    $mussanit_prices[1]["2.0"]=38024;

    $mussanit_prices[2]["0.15"]=6924;
    $mussanit_prices[2]["0.25"]=7928;
    $mussanit_prices[2]["0.35"]=8974;
    $mussanit_prices[2]["0.5"]=12228;
    $mussanit_prices[2]["0.7"]=13274;
    $mussanit_prices[2]["0.95"]=14738;
    $mussanit_prices[2]["1.1"]=19829;
    $mussanit_prices[2]["1.35"]=23385;
    $mussanit_prices[2]["1.5"]=28195;
    $mussanit_prices[2]["1.75"]=32796;
    $mussanit_prices[2]["2.0"]=38024;

    $mussanit_prices[3]["0.15"]=6924;
    $mussanit_prices[3]["0.25"]=7928;
    $mussanit_prices[3]["0.35"]=8974;
    $mussanit_prices[3]["0.5"]=12228;
    $mussanit_prices[3]["0.7"]=13274;
    $mussanit_prices[3]["0.95"]=14738;
    $mussanit_prices[3]["1.1"]=19829;
    $mussanit_prices[3]["1.35"]=23385;
    $mussanit_prices[3]["1.5"]=28195;
    $mussanit_prices[3]["1.75"]=32796;
    $mussanit_prices[3]["2.0"]=38024;


    $mussanit_prices[4]["0.15"]=6924;
    $mussanit_prices[4]["0.25"]=7928;
    $mussanit_prices[4]["0.35"]=8974;
    $mussanit_prices[4]["0.5"]=12228;
    $mussanit_prices[4]["0.7"]=13274;
    $mussanit_prices[4]["0.95"]=14738;
    $mussanit_prices[4]["1.1"]=19829;
    $mussanit_prices[4]["1.35"]=23385;
    $mussanit_prices[4]["1.5"]=28195;
    $mussanit_prices[4]["1.75"]=32796;
    $mussanit_prices[4]["2.0"]=38024;


    $mussanit_prices[5]["0.25"]=7928;
    $mussanit_prices[5]["0.35"]=8974;
    $mussanit_prices[5]["0.5"]=12228;
    $mussanit_prices[5]["0.7"]=13274;
    $mussanit_prices[5]["0.95"]=14738;
    $mussanit_prices[5]["1.1"]=19829;
    $mussanit_prices[5]["1.35"]=23385;
    $mussanit_prices[5]["1.5"]=28195;
    $mussanit_prices[5]["1.75"]=32796;
    $mussanit_prices[5]["2.0"]=38024;

    $mussanit_prices[6]["0.25"]=7928;
    $mussanit_prices[6]["0.35"]=8974;
    $mussanit_prices[6]["0.5"]=12228;
    $mussanit_prices[6]["0.7"]=13274;
    $mussanit_prices[6]["0.95"]=14738;
    $mussanit_prices[6]["1.1"]=19829;
    $mussanit_prices[6]["1.35"]=23385;
    $mussanit_prices[6]["1.5"]=28195;
    $mussanit_prices[6]["1.75"]=32796;
    $mussanit_prices[6]["2.0"]=38024;

    $mussanit_prices[7]["0.15"]=6924;
    $mussanit_prices[7]["0.25"]=7928;
    $mussanit_prices[7]["0.35"]=8974;
    $mussanit_prices[7]["0.5"]=12228;
    $mussanit_prices[7]["0.7"]=13274;
    $mussanit_prices[7]["0.95"]=14738;
    $mussanit_prices[7]["1.1"]=19829;
    $mussanit_prices[7]["1.35"]=23385;
    $mussanit_prices[7]["1.5"]=28195;
    $mussanit_prices[7]["1.75"]=32796;
    $mussanit_prices[7]["2.0"]=38024;

    $mussanit_prices[8]["0.15"]=6924;
    $mussanit_prices[8]["0.25"]=7928;
    $mussanit_prices[8]["0.35"]=8974;
    $mussanit_prices[8]["0.5"]=12228;
    $mussanit_prices[8]["0.7"]=13274;
    $mussanit_prices[8]["0.95"]=14738;
    $mussanit_prices[8]["1.1"]=19829;
    $mussanit_prices[8]["1.35"]=23385;
    $mussanit_prices[8]["1.5"]=28195;
    $mussanit_prices[8]["1.75"]=32796;
    $mussanit_prices[8]["2.0"]=38024;



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
Route::post('/order-gift','ConstructorController@ordergift');
