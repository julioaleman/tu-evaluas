<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\User;
use App\Models\Blueprint;

class Blueprints extends Controller
{
  //
  // [ L I S T ]
  //
  //
  public function index(Request $request){
    $user = Auth::user();
    $data = [];

    $data['title']       = 'Encuestas Tú Evalúas';
    $data['description'] = '';
    $data['body_class']  = 'surveys';
    $data['surveys']     = $user->level == 3 ? Blueprint::all() : $user->blueprints;
    $data['user']        = $user;
    $data['status']      = session('status');

    return view("blueprints")->with($data);
  }

  //
  // [ C R E A T E ]
  //
  //
  public function create(Request $request){
    $user  = Auth::user();
    $title = $request->input("title");
    if(empty($title)) return redirect('dashboard/encuestas');

    $blueprint = new Blueprint;
    $blueprint->title      = $title;
    $blueprint->user_id    = $user->id;
    $blueprint->is_closed  = 0;
    $blueprint->is_public  = 0;
    $blueprint->is_visible = 1;
    $blueprint->save();
    $request->session()->flash('status', ['type' => 'create', 'name' => $blueprint->title]);

    return redirect('dashboard/encuestas');
  }

  //
  // [ E D I T O R ]
  //
  //
  public function blueprint($id){
    $user = Auth::user();
    $blueprint = $user->level == 3 ? Blueprint::with(["questions.options", "rules"])->find($id) : $user->blueprints->with(with(["questions.options", "rules"]))->find($id);

    if(!$blueprint) return redirect("dashboard/encuestas");

    $data = [];
    $data['title']       = 'Editar encuesta Tú Evalúas';
    $data['description'] = '';
    $data['body_class']  = 'surveys';
    $data['user']        = $user;
    $data['blueprint']   = $blueprint;

    $data['questions'] = $blueprint->questions;
    $data['rules']     = $blueprint->rules;
    $data['options']   = $blueprint->options;
    //$data['csv_file']  = $csv;
    return view("blueprint")->with($data);
  }

  //
  // [ D E L E T E ]
  //
  //
  public function delete(Request $request, $id){
    $user = Auth::user();
    $blueprint = Blueprint::find($id);
    if($blueprint && ($user->level == 3 || $user->id == $blueprint->user_id)){
      $title = $blueprint->title;
      $blueprint->delete();
      $request->session()->flash('status', ['type' => 'delete', 'name' => $title]);
      return redirect('dashboard/encuestas');
    }
    else{
      return redirect('dashboard/encuestas');
    }
  }
}
