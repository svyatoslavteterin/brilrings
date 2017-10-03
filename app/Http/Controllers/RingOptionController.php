<?php

namespace App\Http\Controllers;

use App\RingOption;

class RingOptionController extends Controller
{
    //
    public function index(){

      $ring_options=RingOption::all();

      return $ring_options;
    }
}
