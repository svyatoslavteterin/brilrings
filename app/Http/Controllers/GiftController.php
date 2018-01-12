<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gift;

class GiftController extends Controller
{
    //

    //
    public function get(){

      $gifts=Gift::all();

      foreach ($gifts as $gift){


        $gift->images=json_decode($gift->images);

      }
        return $gifts;

    }


}
