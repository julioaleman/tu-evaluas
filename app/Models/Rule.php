<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    //
  public function blueprint(){
    return $this->belongsTo('App\Models\Blueprint');
  }

  public function question(){
    return $this->hasOne('App\Models\Question');
  }
}
