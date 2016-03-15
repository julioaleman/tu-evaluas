<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
  public function blueprint(){
    return $this->belongsTo('App\Models\Blueprint');
  }
}
