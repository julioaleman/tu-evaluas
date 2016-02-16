<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blueprint extends Model
{
  protected $fillable = ['title', 'is_closed', 'is_visible', 'csv_file', 'banner', 'tags', 'category'];
  
  public function user(){
    return $this->belongsTo('App\User');
  }

  public function questions(){
    return $this->hasMany('App\Models\Question');
  }

  public function rules(){
    return $this->hasMany('App\Models\Rule');
  }

  public function options(){
    return $this->hasMany('App\Models\Option');
  }
}
