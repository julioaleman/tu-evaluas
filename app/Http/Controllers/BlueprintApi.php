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
    // Redirect::back()->with('new_token', csrf_token());
    // CHECK IF THE BLUEPRINT EXIST AND THE USER CAN CHANGE IR
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

    $r = $request->all();

    $question = new 
    return response()->json($r)->header('Access-Control-Allow-Origin', '*');
    }
  }

  public function getQuestion($id){
    
  }

  public function updateQuestion(Request $request, $id){
    
  }

  public function deleteQuestion($id){
    
  }
}
