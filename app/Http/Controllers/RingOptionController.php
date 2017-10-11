<?php

namespace App\Http\Controllers;

use App\RingOption;

class RingOptionController extends Controller
{
    //
    public function get(){

      $ring_options=RingOption::all()->where('parent_id',0);

    
      foreach ($ring_options as $ring_option){
        $output[$ring_option->key]=$ring_option->children;
      }

      return $output;
    }

    public function show(RingOption $ring_option){

      return $ring_option;
    }



    public function getValues($id){

      $ring_option=RingOption::find($id);


      return $ring_option->values()->get();

    }
}
