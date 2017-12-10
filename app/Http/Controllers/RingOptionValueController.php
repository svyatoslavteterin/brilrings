<?php

namespace App\Http\Controllers;

use App\RingOptionValue,App\RingOption;

class RingOptionValueController extends Controller
{
  public function index(){

    $ring_option_values=RingOptionValue::where('enabled','=',1)->get();

    return $ring_option_values;
  }

  public function get(){
    $ring_option_values=RingOptionValue::where('enabled','=',1)->orderBy('sort_index','asc')->orderBy('id','asc')->get();

    $output=array();
    foreach ($ring_option_values as $ring_option_value) {

    $ring_option_value->price=json_decode($ring_option_value->price);
      $c=clone $ring_option_value;
      $ring_option=$c->ringOption;

      $output[$ring_option->key][]=$ring_option_value;

    }

    return $output;
  }

}
