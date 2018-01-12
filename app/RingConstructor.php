<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RingOption;

class RingConstructor extends Model
{
    //

    static public function getHash($params){

      $options=RingOption::where('id','<',11)->get();
      $str='';


      foreach ($options as $option){

         if (!isset($params[$option['key']])) $params[$option['key']]=1;

        $str.=$option['key'].$params[$option['key']];

      }

      return md5($str);
    }
}
