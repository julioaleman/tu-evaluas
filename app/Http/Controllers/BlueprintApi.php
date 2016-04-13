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
    if($user->level == 3){
      $blueprint = Blueprint::find($request->input('blueprint_id'));
    }
    else{
      $blueprint = Blueprint::where("user_id",$user->id )->find($request->input('blueprint_id'));
    }

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
    //$question->is_location    = $request->input("is_location");
    $question->type           = $request->input("type");

    $question->save();
    $options = [];

    // [3] IF THE QUESTION HAS OPTIONS, CREATE THEM
    if(!empty($request->input('options'))){
      $val = 1;
      foreach($request->input('options') as $opt){
        $option = new Option;
        $option->question_id  = $question->id;
        $option->blueprint_id = $blueprint->id;
        $option->description  = $opt;
        $option->value        = $val;
        $option->name         = uniqid();
        $option->order_num    = $val;
        $option->save();
        $options[] = $option;
        $val++;
      }
      $remove_rule = 0;
    }
    else{
      $remove_rule = Rule::where("blueprint_id", $blueprint->id)->where("question_id", $question->id)->delete();
    }
    $question->options     = $options;
    $question->remove_rule = $remove_rule;

    // [4] GENERATE A NEW TOKEN TO PREVENT TOKEN MISSMATCH
    $question->new_token = csrf_token();

    // [5] RETURN THE JSON
    return response()->json($question)->header('Access-Control-Allow-Origin', '*');
  }


  public function getQuestion($id){
    
  }

  public function updateQuestion(Request $request, $id){
    // [1] CHECK IF THE BLUEPRINT EXIST AND THE USER CAN CHANGE IT
    $user        = Auth::user();
    $question    = Question::find($id); // here we need more validation
    $blueprint   = $question->blueprint;
    $old_section = $question->section_id;

    // [2] CREATE THE QUESTION OBJECT
    $question->section_id  = (int)$request->input("section_id");
    $question->question    = $request->input("question");
    $question->is_location = $request->input("is_location", 0);
    $question->type        = $request->input("type", 'text');

    $question->update();
    $options = [];

    // [3] IF THE QUESTION HAS OPTIONS, CREATE THEM
    if(!empty($request->input('options'))){
      Option::where("question_id", $question->id)->delete();
      $val = 1;

      foreach($request->input('options') as $opt){
        $option = new Option;
        $option->question_id  = $question->id;
        $option->blueprint_id = $question->blueprint_id;
        $option->description  = $opt;
        $option->value        = $val;
        $option->name         = uniqid();
        $option->order_num    = $val;
        $option->save();
        $options[] = $option;
        $val++;
      }
      $remove_rule = 0;
    }
    else{
      $remove_rule = Rule::where("blueprint_id", $blueprint->id)->where("question_id", $question->id)->delete();
    }
    if($old_section != $question->section_id){
      $remove_rule = 1;
    }
    $question->options     = $options;
    $question->remove_rule = $remove_rule;

    // [4] GENERATE A NEW TOKEN TO PREVENT TOKEN MISSMATCH
    $question->new_token = csrf_token();

    // [5] RETURN THE JSON
    return response()->json($question)->header('Access-Control-Allow-Origin', '*');
  }

  public function deleteQuestion($id){
    $user      = Auth::user();
    $question  = Question::find($id);
    $blueprint = $question->blueprint;
    Option::where("question_id", $question->id)->delete();
    $remove_rule = Rule::where("blueprint_id", $blueprint->id)->where("question_id", $question->id)->delete();
    $delete      = $question->delete();
    $response = ["remove_rule" => $remove_rule, "delete" => $delete];

    return response()->json($response)->header('Access-Control-Allow-Origin', '*');
  }

  public function saveRule(Request $request){
    // [1] CHECK IF THE BLUEPRINT EXIST AND THE USER CAN CHANGE IT
    $user      = Auth::user();
    $blueprint = Blueprint::find($request->input('blueprint_id'));

    if(!$blueprint){
      if($user->level == 3){
        abort(404, 'El formulario no existe!');
      }
      else{
        abort(403, 'El formulario no pertenece al usuario');
      }
    }

    // [2] CREATE THE RULE OBJECT
    $rule = new Rule;
    $rule->blueprint_id = $blueprint->id;
    $rule->section_id   = (int)$request->input("section_id");
    $rule->question_id  = (int)$request->input("question_id");
    $rule->value        = $request->input("value");
    
    $rule->save();
   
    // [4] GENERATE A NEW TOKEN TO PREVENT TOKEN MISSMATCH
    $rule->new_token = csrf_token();

    // [5] RETURN THE JSON
    return response()->json($rule)->header('Access-Control-Allow-Origin', '*');
  }

  public function deleteRule($id){
    $user = Auth::user();
    $rule = Rule::find($id);
    $response = $rule->delete();
    return response()->json($response)->header('Access-Control-Allow-Origin', '*');
  }
}
