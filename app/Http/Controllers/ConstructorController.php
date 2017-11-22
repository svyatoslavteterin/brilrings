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
          7=>'J',
          8=>'K',
          9=>'N'
        );

        $clarity_aliases=array(
          1=>'IF',
          2=>'VVS1',
          3=>'VVS1',
          4=>'VVS2',
          5=>'VS1',
          6=>'VS2',
          7=>'SI1',
          8=>'SI3',
          9=>'I1',
          10=>'I1',
          11=>'I1',
          12=>'I1'
        );




        $paramsA["shape"] = $shape_aliases[$shape];
        $paramsA["size"] = $weight;
        $paramsA["color"] = $color_aliases[$color];
        $paramsA["clarity"] = $clarity_aliases[$clarity];


        $data = '{"request": {"header": {"username": "qucawnvvxoe0aeueyhbgc1hwkkejgb","password": "vcR3jGQ3"},
        "body": {
        "shapes": ["'.$paramsA["shape"].'"],';

        if ($paramsA["shape"]=="Round") {

        $data.= '"size_to": '.$paramsA["size"].',
                "size_from": '.$paramsA["size"].',';

        }
        $data.='
        "clarity_from": "IF",
        "clarity_to": "I1",
        "cut_from": "Excellent",
        "cut_to": "Good",
        "polish_from": "Excellent",
        "polish_to": "Good",
        "symmetry_from": "Excellent",
        "symmetry_to": "Good",
        "labs": ["GIA","IGI", "AGS","HRD","NONE","CGL"],
        "price_total_from": 0.00,
        "price_total_to": 20000.00,
        "page_number": 1,
        "page_size": 50,
        "sort_by": "price",
        "sort_direction": "ASC"

        }}}';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($curl, CURLOPT_URL, 'http://technet.rapaport.com/HTTP/JSON/RetailFeed/GetDiamonds.aspx');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($curl);
        $response = json_decode($result, true);
          curl_close($curl);


        if ($response['response']['header']['error_code']==4001) {
          $data=str_replace($paramsA["size"],'0.23',$data);
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

          curl_setopt($curl, CURLOPT_URL, 'http://technet.rapaport.com/HTTP/JSON/RetailFeed/GetDiamonds.aspx');
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

              $result = curl_exec($curl);
          $response = json_decode($result, true);
            curl_close($curl);



        }


        $total_diamonds=$response['response']['body']['search_results']['total_diamonds_found'];
        $diamonds=$response['response']['body']['diamonds'];


          if ($paramsA["shape"]!="round"){
            $include_diamonds=array();
            foreach ($diamonds as $key=>$diamond){
              if ($diamond['size']==$paramsA['size']){
                $include_diamonds[]=$diamond;
              }
            }
            if (count($include_diamonds)==0) {



              foreach ($diamonds as $key=>$diamond){


                if (abs($diamond['size']-$paramsA['size'])<=0.1){
                  $include_diamonds[]=$diamond;
                }
              }
            }

            if (count($include_diamonds==0)){


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
          }

        $prices=array();
        foreach ($diamonds as $diamond){

          if ($diamond['clarity']==$paramsA['clarity'] && $diamond['color']==$paramsA['color']){
              $prices[]=round($diamond['total_sales_price_in_currency']);
          }

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
        $return=new \stdClass();
        $return->price=$average_price;
        return   \Response::json($return);


    }
}
