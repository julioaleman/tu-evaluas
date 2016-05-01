<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailgunEmail extends Model
{
	protected $fillable = ["blueprint", "emails"];

	public function blueprint(){
    return $this->belongsTo('App\Models\Blueprint', 'blueprint');
  }
    //
}
