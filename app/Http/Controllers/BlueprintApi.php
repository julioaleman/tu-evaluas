<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\User;
use App\Models\Blueprint;
use App\Models\Question;
use App\Models\Option;
use App\Models\Rule;

class BlueprintApi extends Controller
{
  public function saveQuestion(Request $request){
    // [1] CHECK IF THE BLUEPRINT EXIST AND THE USER CAN CHANGE IT
    $user = Auth::user();
    $blueprint = $user->level == 3 ? Blueprint::find($request->input('blueprint_id')) : $user->blueprint->find($request->input('blueprint_id'));
    if(!$blueprint){
      if($user->level == 3){
        abort(404, 'El formulario no existe!');
      }
      else{
        abort(403, 'El formulario no pertenece al usuario');
      }
    }

    // [2] CREATE THE QUESTION OBJECT
    $question = new Question;
    $question->user_id        = $user->id;
    $question->blueprint_id   = $blueprint->id;
    $question->section_id     = (int)$request->input("section_id");
    $question->question       = $request->input("question");
    $question->is_description = $request->input("is_description");
    $question->is_location    = $request->input("is_location");
    $question->type           = $request->input("type");

    $question->save();
    $options = [];

    // [3] IF THE QUESTION HAS OPTIONS, CREATE THEM
    if(empty($request->options)){
      $val = 1;
      foreach($request->options as $opt){
        $option = new Option;
        $option->question_id  = $question->id;
        $option->blueprint_id = $blueprint->id;
        $option->description  = $opt;
        $option->value        = $val;
        $option->name         = uniqid();
        $option->order_num    = $val;
        $option->save;
        $options[] = $option;
        $val++;
      }
    }
    $question->options   = $options;

    // [4] GENERATE A NEW TOKEN TO PREVENT TOKEN MISSMATCH
    $question->new_token = csrf_token();

    // [5] RETURN THE JSON
    return response()->json($question)->header('Access-Control-Allow-Origin', '*');
  }


  public function getQuestion($id){
    
  }

  public function updateQuestion(Request $request, $id){
    
  }

  public function deleteQuestion($id){
    
  }
}
