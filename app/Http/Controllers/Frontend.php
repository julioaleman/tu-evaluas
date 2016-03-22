<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Blueprint;
use App\Models\Answer;

class Frontend extends Controller
{
  const PAGE_SIZE = 3;
  //
  //
  //
  //
  function index(){
    $data                = [];
    $data['title']       = 'Tú Evalúas';
    $data['description'] = 'Tu opinión sobre los programas públicos federales ayuda a mejorarlos.';
    $data['body_class']  = 'home';
    $data['surveys']     = Blueprint::where("is_public", 1)->where("is_visible", 1)->get();
    return view("home")->with($data);
  }

  //
  //
  //
  //
  function about(){
    $data = [];
    $data['title']       = 'Qué es Tú Evalúas';
    $data['description'] = 'Tú evalúas es una iniciativa dirigida a los beneficiarios de los programas públicos federales.';
    $data['body_class']  = 'about';
    return view("frontend.about")->with($data);
  }

  //
  //
  //
  //
  function faqs(){
    $data = [];
    $data['title']       = 'Preguntas Frecuentes | Tú Evalúas';
    $data['description'] = 'Algunas de las preguntas frecuentes de la plataforma Tú Evalúas';
    $data['body_class']  = 'faqs';
    return view("frontend.faqs")->with($data);
  }

  //
  //
  //
  //
  function results(Request $request, $page = 1){
    if(empty($request->all())){
      $blueprints = Blueprint::where("is_public", 1)->skip(($page-1) * self::PAGE_SIZE)->take(self::PAGE_SIZE)->get();
      $total = Blueprint::where("is_public", 1)->count();
    }
    else{
      $blueprints = Blueprint::where("is_public", 1)->where(function($q) use($request){
        // search title
        if($request->input("title", null)){
          $q->where("title", "like", "%". $request->input("title") . "%");
        }
        // search category
        if($request->input("category", null)){
          $q->where("category", $request->input("category"));
        }
        // search subcategory
        if($request->input("survey-subs", null)){
          $subs = $request->input("survey-subs");
          $q->where(function($q) use($subs){
            $first = array_shift($subs);
            $q->where("subcategory", "like", "%" . $first . "%");
            foreach($subs as $sub){
              $q->orWhere("subcategory", "like", "%" . $sub . "%");
            }
          });
        }
        // search tags
        if($request->input("survey-tags", null)){
          $tags = $request->input("survey-tags");
          $q->where(function($q) use($tags){
            $first = array_shift($tags);
            $q->where("tags", "like", "%" . $first . "%");
            foreach($tags as $tag){
              $q->orWhere("tags", "like", "%" . $tag . "%");
            }
          });
        }
      })->skip(($page-1) * self::PAGE_SIZE)->take(self::PAGE_SIZE)->get();

      $total = Blueprint::where("is_public", 1)->where(function($q) use($request){
        // search title
        if($request->input("title", null)){
          $q->where("title", "like", "%". $request->input("title") . "%");
        }
        // search category
        if($request->input("category", null)){
          $q->where("category", $request->input("category"));
        }
        // search subcategory
        if($request->input("survey-subs", null)){
          $subs = $request->input("survey-subs");
          $q->where(function($q) use($subs){
            $first = array_shift($subs);
            $q->where("subcategory", "like", "%" . $first . "%");
            foreach($subs as $sub){
              $q->orWhere("subcategory", "like", "%" . $sub . "%");
            }
          });
        }
        // search tags
        if($request->input("survey-tags", null)){
          $tags = $request->input("survey-tags");
          $q->where(function($q) use($tags){
            $first = array_shift($tags);
            $q->where("tags", "like", "%" . $first . "%");
            foreach($tags as $tag){
              $q->orWhere("tags", "like", "%" . $tag . "%");
            }
          });
        }
      })->count();
    }
    $categories = file_get_contents(public_path() . "/". "js/categories.json");
    $data = [];
    $data['surveys']     = $blueprints;
    $data['title']       = 'Resultados | Tú Evalúas';
    $data['description'] = 'Resultados de cuestionarios en Tú Evalúas';
    $data['body_class']  = 'results';
    $data['categories']  = collect(json_decode($categories));
    $data['request']     = $request;
    $data['page']        = $page;
    $data['total']       = $total;
    $data['pages']       = ceil($total/self::PAGE_SIZE);
    return view("frontend.results")->with($data);
  }

  //
  //
  //
  //
  function result($id){
    $blueprint = Blueprint::with(["questions.options", "rules"])->find($id);


    if(!$blueprint) die("Este formulario no existe!");

    $data = [];
    $data['blueprint']  = $blueprint;
    $data['title']       = 'Resultados | Tú Evalúas';
    $data['description'] = 'Resultados de cuestionarios en Tú Evalúas';
    $data['body_class']  = 'results';
    return view("frontend.result_survey")->with($data);
  }

  //
  //
  //
  //
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
