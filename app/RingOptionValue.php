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
}
