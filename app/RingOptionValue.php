<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RingOptionValue extends Model
{
    //

    public function ringOption(){
      return $this->belongsTo(ringOption::class);
    }
}
