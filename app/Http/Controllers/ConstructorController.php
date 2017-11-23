<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConstructorController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($base,$material)
    {
      return view('constructor/base',compact('material','base'));
    }
    public function getprice($shape,$weight,$color,$clarity){



        $weights=\App\RingOptionValue::where('ring_option_id','=',7)->get();

        foreach ($weights->toArray() as $weight_arr){
          if ($weight_arr['value']==$weight){

            $weight=$weight_arr['title'];
          }
        }


        $shape_aliases=array(
          1=>'Round',
          2=>'Princess',
          3=>'Oval',
          4=>'Asscher',
          5=>'Heart',
          6=>'Pear',
          7=>'Cushion',
          8=>'Emerald'
        );


        $color_aliases=array(
          1=>'D',
          2=>'E',
          3=>'F',
          4=>'G',
          5=>'H',
          6=>'I',
          7=>'J'
        );

        $clarity_aliases=array(
          1=>'IF',
          2=>'VVS1',
          3=>'VVS1',
          4=>'VVS2',
          5=>'VS1',
          6=>'VS2',
          7=>'SI2',
          8=>'SI3',
          9=>'I1',
          10=>'I2',
          11=>'I2',
          12=>'I2'
        );



        $delta_color=5;
        $delta_clarity=6;
        $delta_size=0.1;


        $paramsA["shape"] = $shape_aliases[$shape];
        $paramsA["size"] = $weight;
        $paramsA["color"] = $color_aliases[$color];
        $paramsA["clarity"] = $clarity_aliases[$clarity];

        $request=new \StdClass();
        $request->request=new \StdClass();
        $request_header=new \StdClass();

        $request_header->username="qucawnvvxoe0aeueyhbgc1hwkkejgb";
        $request_header->password="vcR3jGQ3";


        $request_body=new \StdClass();

        $request_body->shapes=array($paramsA["shape"]);
        $request_body->size_to=$paramsA["size"];
        $request_body->size_from=$paramsA["size"];


        $request_body->page_number=1;
        $request_body->page_size=50;
        $request_body->sort_by="price";
        $request_body->sort_direction="ASC";






      $request->request->header=$request_header;
      $request->request->body=$request_body;



              if (preg_match('/\-/i', $paramsA['color'])){
                $c=explode('-',$paramsA['color']);
                $request_body->color_from=$c[0];
                $request_body->color_to=$c[1];
              }else{
                $request_body->color_to=$paramsA["color"];
                $request_body->color_from=$paramsA["color"];
              }

                if (preg_match('/\-/i', $paramsA['clarity'])){
                    $c=explode('-',$paramsA['clarity']);
                  $request_body->clarity_from=$c[0];
                  $request_body->clarity_to=$c[1];


            }else{
              $request_body->clarity_to=$paramsA["clarity"];
              $request_body->clarity_from=$paramsA["clarity"];
            }



        


        $data=json_encode($request);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($curl, CURLOPT_URL, 'http://technet.rapaport.com/HTTP/JSON/RetailFeed/GetDiamonds.aspx');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($curl);
        $response = json_decode($result, true);
          curl_close($curl);

$total_diamonds=0;



        if ($response['response']['header']['error_code']==4001) {




          if ($paramsA['shape']!="Round"){

            $request_body->size_from=$paramsA['size'];
            $request_body->size_to=$paramsA['size']+$delta_size;
          }
          if ($color<round(count($color_aliases)/2)){
            $diff=$color+$delta_color;
            if ($diff<1) $diff=1;
            if ($diff>count($color_aliases)) $diff=count($color_aliases);
            $request_body->color_to=$color_aliases[$diff];
          }else{
            $diff=$color-$delta_color;
            if ($diff<1) $diff=1;
            if ($diff>count($color_aliases)) $diff=count($color_aliases);
            $request_body->color_from=$color_aliases[$diff];
          }

          if ($clarity<round(count($clarity_aliases)/2)){
            $diff=$clarity+$delta_clarity;
            if ($diff<1) $diff=1;
            if ($diff>count($clarity_aliases)) $diff=count($clarity_aliases);
            $request_body->clarity_to=$clarity_aliases[$diff];
          }else{
            $diff=$clarity-$delta_clarity;
            if ($diff<1) $diff=1;
            if ($diff>count($clarity_aliases)) $diff=count($clarity_aliases);
            $request_body->clarity_from=$clarity_aliases[$diff];
          }



          $curl = curl_init();
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));

          curl_setopt($curl, CURLOPT_URL, 'http://technet.rapaport.com/HTTP/JSON/RetailFeed/GetDiamonds.aspx');
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

              $result = curl_exec($curl);
          $response = json_decode($result, true);
            curl_close($curl);






        }





$total_diamonds=$response['response']['body']['search_results']['total_diamonds_found'];


$diamonds=$response['response']['body']['diamonds'];


            $include_diamonds=array();
          if ($paramsA["shape"]!="Round"){

            foreach ($diamonds as $key=>$diamond){
              if ($diamond['size']==$paramsA['size']){
                $include_diamonds[]=$diamond;
              }
            }
            if (count($include_diamonds)==0) {



              foreach ($diamonds as $key=>$diamond){


                if (abs($diamond['size']-$paramsA['size'])<=$delta_size){
                  $include_diamonds[]=$diamond;
                }
              }
            }

            if (count($include_diamonds)==0){


              if ($diamonds[count($diamonds)-1]['size']>$paramsA['size']){
                $paramsA['size']=$diamonds[0]['size'];
              }else{

                $paramsA['size']=$diamonds[count($diamonds)-1]['size'];
              }

              foreach ($diamonds as $key=>$diamond){
                if ($diamond['size']==$paramsA['size']){
                  $include_diamonds[]=$diamond;
                }
              }

            }
            $diamonds=$include_diamonds;
          }else{ // if SHAPE ROUND

            foreach ($diamonds as $key=>$diamond){
              if (($diamond['size']==$paramsA['size']) && ($diamond['color']==$paramsA['color'])&& ($diamond['clarity']==$paramsA['clarity']) ){
                $include_diamonds[]=$diamond;
              }
            }


              if (count($include_diamonds)<=3){

                  foreach ($diamonds as $key=>$diamond){

                  $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);


                  $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);

                  if (($diamond['size']==$paramsA['size']) && ($delta_color<=2) && ($delta_clarity<=3) ) {

                      $include_diamonds[]=$diamond;


                  }
                }
              }



                if (count($include_diamonds)<=3){

                  foreach ($diamonds as $key=>$diamond){

                  $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);

                  $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);

                    if (($diamond['size']==$paramsA['size']) && ($delta_color<=3) && ($delta_clarity<=3) ) {

                        $include_diamonds[]=$diamond;


                    }
                  }
                }
                if (count($include_diamonds)<=3){
                  foreach ($diamonds as $key=>$diamond){

                  $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);

                  $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);

                    if (($diamond['size']==$paramsA['size']) && ($delta_color<=3) && ($delta_clarity<=4)) {

                        $include_diamonds[]=$diamond;


                    }
                  }
                }
                if (count($include_diamonds)<=3){
                  foreach ($diamonds as $key=>$diamond){

                  $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);

                  $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);

                    if (($diamond['size']==$paramsA['size']) && ($delta_color<=4) && ($delta_clarity<=4)) {

                        $include_diamonds[]=$diamond;


                    }
                  }
                }
                if (count($include_diamonds)<=3){
                  foreach ($diamonds as $key=>$diamond){

                  $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);

                  $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);

                    if (($diamond['size']==$paramsA['size']) && ($delta_color<=4) && ($delta_clarity<=5)) {

                        $include_diamonds[]=$diamond;


                    }
                  }
                }
                if (count($include_diamonds)<=3){
                  foreach ($diamonds as $key=>$diamond){

                  $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);

                  $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);

                    if (($diamond['size']==$paramsA['size']) && ($delta_color<=5) && ($delta_clarity<=5)) {

                        $include_diamonds[]=$diamond;


                    }
                  }
                }
                if (count($include_diamonds)<=3){
                  foreach ($diamonds as $key=>$diamond){

                  $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);

                  $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);

                    if (($diamond['size']==$paramsA['size']) && ($delta_color<=5) && ($delta_clarity<=6)) {

                        $include_diamonds[]=$diamond;


                    }
                  }
                }

            $diamonds=$include_diamonds;



          }

        $prices=array();
        foreach ($diamonds as $diamond){


              $prices[]=round($diamond['total_sales_price_in_currency']);


        }


        if (count($prices)==0){
            foreach ($diamonds as $diamond){
              if ($diamond['clarity']==$paramsA['clarity']){
                  $prices[]=round($diamond['total_sales_price_in_currency']);
              }
            }
        }

        if (count($prices)==0){
            foreach ($diamonds as $diamond){
                $prices[]=round($diamond['total_sales_price_in_currency']);
            }
        }




        $average_price=round(($prices[0]+$prices[count($prices)-1])/2);

        if ($total_diamonds>50){
          $request_body->sort_direction="DESC";
          $data=json_encode($request);

          $curl = curl_init();
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

          curl_setopt($curl, CURLOPT_URL, 'http://technet.rapaport.com/HTTP/JSON/RetailFeed/GetDiamonds.aspx');
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

              $result = curl_exec($curl);
          $response = json_decode($result, true);
            curl_close($curl);
              $diamonds=$response['response']['body']['diamonds'];
              $prices=array();


              foreach ($diamonds as $diamond){


                      if ((($diamond['size']==$paramsA['size']) && ($diamond['color']==$paramsA['color'])&& ($diamond['clarity']==$paramsA['clarity']))||(abs($diamond['size']-$paramsA['size']<=$delta_size)) ){
                        $prices[]=round($diamond['total_sales_price_in_currency']);
                      }

              }



                      if (count($prices)<=3){
                          foreach ($diamonds as $diamond){
                            $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);
                            $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);
                              if (($diamond['size']==$paramsA['size']) && ($delta_color<=2) && ($delta_clarity<=3) ) {
                                $prices[]=round($diamond['total_sales_price_in_currency']);
                              }
                        }
                      }
                      if (count($prices)<=3){
                          foreach ($diamonds as $diamond){
                            $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);
                            $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);
                              if (($diamond['size']==$paramsA['size']) && ($delta_color<=3) && ($delta_clarity<=3)) {
                                $prices[]=round($diamond['total_sales_price_in_currency']);
                              }
                        }
                      }
                      if (count($prices)<=3){
                          foreach ($diamonds as $diamond){
                            $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);
                            $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);
                              if (($diamond['size']==$paramsA['size']) && ($delta_color<=3) && ($delta_clarity<=4) ) {
                                $prices[]=round($diamond['total_sales_price_in_currency']);
                              }
                        }
                      }
                      if (count($prices)<=3){
                          foreach ($diamonds as $diamond){
                            $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);
                            $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);
                              if (($diamond['size']==$paramsA['size']) && ($delta_color<=4) && ($delta_clarity<=4) ) {
                                $prices[]=round($diamond['total_sales_price_in_currency']);
                              }
                        }
                      }
                      if (count($prices)<=3){
                          foreach ($diamonds as $diamond){
                            $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);
                            $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);
                              if (($diamond['size']==$paramsA['size']) && ($delta_color<=4) && ($delta_clarity<=5) ) {
                                $prices[]=round($diamond['total_sales_price_in_currency']);
                              }
                        }
                      }
                      if (count($prices)<=3){
                          foreach ($diamonds as $diamond){
                            $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);
                            $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);
                              if (($diamond['size']==$paramsA['size']) && ($delta_color<=5) && ($delta_clarity<=5) ) {
                                $prices[]=round($diamond['total_sales_price_in_currency']);
                              }
                        }
                      }
                      if (count($prices)<=3){
                          foreach ($diamonds as $diamond){
                            $delta_color=abs(array_search($diamond['color'],$color_aliases)-$color);
                            $delta_clarity=abs(array_search($diamond['clarity'],$clarity_aliases)-$clarity);
                              if (($diamond['size']==$paramsA['size']) && ($delta_color<=5) && ($delta_clarity<=6) ) {
                                $prices[]=round($diamond['total_sales_price_in_currency']);
                              }
                        }
                      }





            $average_price2=round(($prices[0]+$prices[count($prices)-1])/2);

            $average_price=round(($average_price+$average_price2)/2);

        } // if total_diamonds>50
        $return=new \stdClass();
        $return->price=$average_price;
        return   \Response::json($return);


    }
}
