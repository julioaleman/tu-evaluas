<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Blueprint;

class Frontend extends Controller
{
  function index(){
    $data                = [];
    $data['title']       = 'Tú Evalúas';
    $data['description'] = 'Tu opinión sobre los programas públicos federales ayuda a mejorarlos.';
    $data['body_class']  = 'home';
    $data['surveys']     = Blueprint::where("is_public", 1)->where("is_visible", 1)->get();
    return view("home")->with($data);
  }

  function about(){
    $data = [];
    $data['title']       = 'Qué es Tú Evalúas';
    $data['description'] = 'Tú evalúas es una iniciativa dirigida a los beneficiarios de los programas públicos federales.';
    $data['body_class']  = 'about';
    return view("about")->with($data);
  }
  
  function faqs(){
    $data = [];
    $data['title']       = 'Preguntas Frecuentes | Tú Evalúas';
    $data['description'] = 'Algunas de las preguntas frecuentes de la plataforma Tú Evalúas';
    $data['body_class']  = 'faqs';
    return view("faqs")->with($data);
  }
  
  function results(){
    $data = [];
    $data['title']       = 'Resultados | Tú Evalúas';
    $data['description'] = 'Resultados de cuestionarios en Tú Evalúas';
    $data['body_class']  = 'results';
    return view("results")->with($data);
  }

  function blueprintDocsCSV(){
    echo ":D";
  }
}
