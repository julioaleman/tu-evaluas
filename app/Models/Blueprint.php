<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blueprint extends Model
{
  protected $fillable = ['title', 'is_closed', 'is_visible', 'csv_file', 'banner', 'tags', 'category', 'subcategory', 'ptp', 'unit', 'branch', 'program'];
  
  public function user(){
    return $this->belongsTo('App\User');
  }

  public function questions(){
    return $this->hasMany('App\Models\Question');
  }

  public function applicants(){
    return $this->hasMany('App\Models\Applicant');
  }

  public function rules(){
    return $this->hasMany('App\Models\Rule');
  }

  public function options(){
    return $this->hasMany('App\Models\Option');
  }
}
