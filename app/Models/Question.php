<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
  public function blueprint(){
    return $this->belongsTo('App\Models\Blueprint');
  }

  public function options(){
    return $this->hasMany('App\Models\Option');
  }

  public function answers(){
    return $this->hasMany('App\Models\Answer');
  }

}

