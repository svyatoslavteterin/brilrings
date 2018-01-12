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
    $ring_option_values=RingOptionValue::where('enabled','=',1)->where('ring_option_id','<',11)->orderBy('sort_index','asc')->orderBy('id','asc')->get();

    $output=array();

    $output=RingOptionValue::group($ring_option_values);
    return $output;
  }

  public static function getGiftOptionValues(){
    $ring_option_values=RingOptionValue::where('enabled','=',1)->where('ring_option_id','>',11)->orWhere('ring_option_id','=',4)->orderBy('sort_index','asc')->orderBy('id','asc')->get();

    $output=array();

    $output=RingOptionValue::group($ring_option_values);
    return $output;
  }
}
