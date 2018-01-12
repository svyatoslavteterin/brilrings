<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RingOptionValue extends Model
{
    //
    public $timestamps = false;
    public function ringOption(){
      return $this->belongsTo(RingOption::class);
    }

    public static function group($option_values){

      foreach ($option_values as $option_value) {

      $option_value->price=json_decode($option_value->price);
        $c=clone $option_value;
        $option=$c->ringOption;

        $output[$option->key][]=$option_value;

      }

        return $output;
    }
}
