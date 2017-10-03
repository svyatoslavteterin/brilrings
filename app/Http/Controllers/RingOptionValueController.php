<?php

namespace App\Http\Controllers;

use App\RingOptionValue;

class RingOptionValueController extends Controller
{
  public function index(){

    $ring_option_values=RingOptionValue::all();

    return $ring_option_values;
  }
}
