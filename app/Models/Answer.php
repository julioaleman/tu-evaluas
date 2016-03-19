<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
  protected $fillable = ["blueprint_id", "question_id", "form_key"];

  public function question(){
    return $this->belongsTo('App\Models\Question');
  }
}