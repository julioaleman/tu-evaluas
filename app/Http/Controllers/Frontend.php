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
    return view("frontend.about")->with($data);
  }
  
  function faqs(){
    $data = [];
    $data['title']       = 'Preguntas Frecuentes | Tú Evalúas';
    $data['description'] = 'Algunas de las preguntas frecuentes de la plataforma Tú Evalúas';
    $data['body_class']  = 'faqs';
    return view("frontend.faqs")->with($data);
  }
  
  function results(){
    $data = [];
    $data['surveys']     = Blueprint::all() ;
    $data['title']       = 'Resultados | Tú Evalúas';
    $data['description'] = 'Resultados de cuestionarios en Tú Evalúas';
    $data['body_class']  = 'results';
    return view("frontend.results")->with($data);
  }
  
  function result($id){
    $blueprint =Blueprint::with(["questions.options", "rules.question"])->find($id);

    if(!$blueprint) die("Este formulario no existe!");

    $data = [];
   
  //  $data['applicant'] = $user;
    $data['blueprint'] = $blueprint;
    $data['questions'] = $blueprint->questions;
    $data['rules']     = $blueprint->rules;
    $data['options']   = $blueprint->options;
    $data['answers']   = [];
    $data['is_test']   = true;

    $data['title']       = 'Resultados | Tú Evalúas';
    $data['description'] = 'Resultados de cuestionarios en Tú Evalúas';
    $data['body_class']  = 'results';
    return view("frontend.result_survey")->with($data);
  }
  
  function terms(){
    $data = [];
    $data['title']       = 'Términos y condiciones de la plataforma | Tú Evalúas';
    $data['description'] = 'Términos y condiciones de la plataforma Tú Evalúas';
    $data['body_class']  = 'terms';
    return view("frontend.terms")->with($data);
  }
  
  function privacy(){
    $data = [];
    $data['title']       = 'Aviso de Privacidad | Tú Evalúas';
    $data['description'] = 'Aviso de Privacidad de la plataforma Tú Evalúas';
    $data['body_class']  = 'privacy';
    return view("frontend.privacy")->with($data);
  }
  
  function contact(){
    $data = [];
    $data['title']       = 'Contacto | Tú Evalúas';
    $data['description'] = 'Envía un mensaje a la plataforma Tú Evalúas';
    $data['body_class']  = 'contact';
    return view("frontend.contact")->with($data);
  }

  function blueprintDocsCSV(){
    echo ":D";
  }
}
