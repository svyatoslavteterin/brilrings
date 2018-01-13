<?php

namespace App\Http\Controllers;

use App\RingImage;
use App\RingOption;
use App\RingConstructor;
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

    public static function getResultImg($base,$material,$current_shape,$weight,$format='json'){



      $weights=\App\RingOptionValue::where('enabled', 1)->where('ring_option_id','=',7)->get();

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


          if (isset($rings_params_map->shapes->{$current_shape})){ // If we have ring with such base and shape



          }else{
            $current_shape=1;

          }

          $sizes=(array)$rings_params_map->shapes->{$current_shape};

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

          $weight=$weight_aliases[$choose_size];

            $params['weight']=$weight;
            $params['shape']= $current_shape;
            $params['material']=$material;
            $params['base']= $base;

            $hash=RingConstructor::getHash($params);


          $result_image=array(
            'original'=>'images/rings/'.$hash.'.jpg',
            'medium'=>'images/rings/medium/'.$hash.'.jpg',
            'small'=>'images/rings/small/'.$hash.'.jpg',
            'extrasmall'=>'images/rings/extrasmall/'.$hash.'.jpg'
          );

          $params['shape']=1;
          $params['size']=1;
          $params['stone']=1;
          $params['weight']=1;
          $params['purity']=1;
          $params['color']=1;
          $params['fsize']=1;

          $hash=RingConstructor::getHash($params);
          $path='images/rings/bok/';

          if ($params['material']>1) {
            $path.='m'.$params['material'].'/';
          }

          $bok_image=array(
            'original'=>$path.'big/'.$hash.'.jpg',
            'small'=>$path.'small/'.$hash.'.jpg'
          );


            $output->shapes=$shapes;
              $output->image=array();
            $output->image[]=$result_image;
            $output->image[]=$bok_image;
            if ($format=="json") return   \Response::json($output);
            return $output;
    }

    public static function makePreview($img,$size){

      switch($size){
        case "big":
          $img->resize(850,null, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            });
          $img->resizeCanvas(850, 850, 'center', false, 'fff');
          break;
        case "medium":
          $img->resize(298,null, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            });
          $img->resizeCanvas(298, null, 'center', false, 'fff');
          break;
        case "small":
          $img->resize(150,null, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            });
          $img->resizeCanvas(150, 150, 'center', false, 'fff');
          break;
        case "extrasmall":
          $img->resize(140,null, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            });
          $img->resizeCanvas(140, 70, 'center', false, 'fff');
          break;

      }

        return $img;
    }
    public function getBaseImg($base,$material,$size='medium',$shape=1){



        $str='';
        $params['base']=$base;
        $params['material']=$material;
        $params['shape']=$shape;
        $params['weight']=8;






      $hash=RingConstructor::getHash($params);

      if (\File::exists('images/rings/'.$hash.'.jpg')){

      }else{
        $params['shape']=1;
        $hash=RingConstructor::getHash($params);


      }

      $img=\Image::make('images/rings/'.$size.'/'.$hash.'.jpg');

    //  $img=$this->makePreview($img,$size);

       return $img->response('jpg',100);
    }
}
