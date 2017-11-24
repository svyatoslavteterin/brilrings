<?php

namespace App\Http\Controllers;

use App\RingImage;
use App\RingOption;
use Illuminate\Http\Request;

class RingImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RingImage  $ringImage
     * @return \Illuminate\Http\Response
     */
    public function show(RingImage $ringImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RingImage  $ringImage
     * @return \Illuminate\Http\Response
     */
    public function edit(RingImage $ringImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RingImage  $ringImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RingImage $ringImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RingImage  $ringImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(RingImage $ringImage)
    {
        //
    }

    public function getResultImg($base,$material,$current_shape,$weight,$hash){


      $weights=\App\RingOptionValue::where('ring_option_id','=',7)->get();

    $weight_aliases=array();
      foreach ($weights->toArray() as $weight_arr){


        $weight_aliases[$weight_arr['title']]=$weight_arr['value'];

      }




           $rings_params_map = json_decode(\Redis::get('ring_params_map:'.$base));
           $shapes=array();
           foreach ($rings_params_map->shapes as $shape=>$shape_sizes){
             $shapes[]=(int)$shape;
           }


          $output=new \StdClass();
          $output->image=new \StdClass();

          $weight=array_search($weight,$weight_aliases);


          if (isset($rings_params_map->shapes->{$shape})){ // If we have ring with such base and shape
            $sizes=(array)$rings_params_map->shapes->{$shape};

            $sizes=array_values($sizes);


              //**** Count delta from shape and next shape in sizes set
              $i=0;
              $choose_size=$sizes[$i];

                if (count($sizes)>1){
                while(abs($sizes[$i]-$weight)>abs($sizes[$i+1]-$weight) ){

                    $choose_size=$sizes[$i+1];
                    $i++;
                    if ($i+1==count($sizes)) break;
                }

                if ($i==count($sizes))   $choose_size=$sizes[$i-1];

              }else{
                $choose_size=$sizes[0];
              }
          }

          $weight=$weight_aliases[$choose_size];

          $options=RingOption::all()->toArray();
          $params=array();
            $str='';

          foreach ($options as $option){
             $params[$option['key']]=1;
            if ($option['key']=="base")   $params[$option['key']]=$base;
            if ($option['key']=="weight")   $params[$option['key']]=$weight;
            if ($option['key']=="material") $params[$option['key']]=$material;
            if ($option['key']=="shape") $params[$option['key']]=$current_shape;



            $str.=$option['key'].$params[$option['key']];

          }
          $hash=md5($str);
          $result_image='images/rings/'.$hash.'.jpg';
            $output->shapes=$shapes;
            $output->image=$result_image;
            return   \Response::json($output);
    }
    public function getBaseImg($base,$material,$size='medium',$shape=1){


      $options=RingOption::all()->toArray();
      $params=array();
        $str='';

      foreach ($options as $option){
         $params[$option['key']]=1;
        if ($option['key']=="base")   $params[$option['key']]=$base;
        if ($option['key']=="weight")   $params[$option['key']]=36;
        if ($option['key']=="material") $params[$option['key']]=$material;
        if ($option['key']=="shape") $params[$option['key']]=$shape;



        $str.=$option['key'].$params[$option['key']];

      }



      $hash=md5($str);


      $img=\Image::make('images/rings/'.$hash.'.jpg');



      if ($size=='medium') {

        $img->resize(298,null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
          });
        $img->resizeCanvas(298, null, 'center', false, 'fff');


      }else{

          $img->resize(140,null, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            });


              $img->resizeCanvas(140, 70, 'center', false, 'fff');
        }

       return $img->response('jpg',100);
    }
}
