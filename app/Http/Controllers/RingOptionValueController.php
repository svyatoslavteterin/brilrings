<?php

namespace App\Http\Controllers;

use App\RingOptionValue;

class RingOptionValueController extends Controller
{
  public function index(){

    $ring_option_values=RingOptionValue::all();

    return $ring_option_values;
  }

  public function get(){
    $ring_option_values=RingOptionValue::all();
    $output=array();
    foreach ($ring_option_values as $ring_option_value) {

      $output[$ring_option_value->ring_option_id][]=$ring_option_value;
    }

    return $output;
  }
}
