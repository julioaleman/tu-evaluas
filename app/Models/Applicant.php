<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
  protected $fillable = ["blueprint_id", "form_key", "user_email", "temporal_key"];
  
  public function blueprint(){
    return $this->belongsTo('App\Models\Blueprint');
  }

  public function answers(){
    return $this->hasMany('App\Models\Answer', 'form_key', 'form_key');
  }
}
