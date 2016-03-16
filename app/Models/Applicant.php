<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
  protected $fillable = ["blueprint_id", "form_key", "user_email"];
  public function blueprint(){
    return $this->belongsTo('App\Models\Blueprint');
  }
}
