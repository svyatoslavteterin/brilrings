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

    public function getResultImg($hash){

       return \Image::make('images/rings/'.$hash.'.jpg')->response('jpg');
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
