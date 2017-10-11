<?php

namespace App\Http\Controllers;

use App\RingOption;

class RingOptionController extends Controller
{
    //
    public function get(){

      $ring_options=RingOption::all()->keyBy('key');;

      return $ring_options;



    }

    public function show(RingOption $ring_option){

      return $ring_option;
    }



    public function getValues($id){

      $ring_option=RingOption::find($id);


      return $ring_option->values()->get();

    }
}
