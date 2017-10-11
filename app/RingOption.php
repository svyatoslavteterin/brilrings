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
}
