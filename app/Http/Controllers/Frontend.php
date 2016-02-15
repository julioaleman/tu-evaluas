<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Frontend extends Controller
{
    //
  function about(){
    $data = [];
    $data['title']       = 'Qué es Tú Evalúas';
    $data['description'] = 'Tú evalúas es una iniciativa dirigida a los beneficiarios de los programas públicos federales.';
    $data['body_class']  = 'about';
    return view("about")->with($data);
  }
}
