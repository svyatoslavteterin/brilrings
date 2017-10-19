<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RingOption extends Model
{
    //

    public function values(){
       return $this->hasMany(RingOptionValue::class);
    }
    public function children(){

       return $this->hasMany(RingOption::class,'parent_id','id');
    }

    public static function getValuesOf($key){
      $ring_option=RingOption::find(4);
      return $ring_option->values()->get();


    }

    public static function getHash($arr){
      $str='';
      foreach ($arr as $key=>$value){
          $str.=$key.$value;
      }

      return md5($str);

    }
}
