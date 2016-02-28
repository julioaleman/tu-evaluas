<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
  public function blueprint(){
    return $this->belongsTo('App\Models\Blueprint');
  }

  public function question(){
    return $this->belongsTo('App\Models\Question');
  }
}
