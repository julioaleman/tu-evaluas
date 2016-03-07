<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\User;
use App\Models\Blueprint;
use Image;

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
    // validate the title
    $this->validate($request, [
      'title' => 'required|max:255'
    ]);

    $user  = Auth::user();
    $title = $request->input("title");

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
  // [ U P D A T E   B L U E P R I N T ]
  //
  //
  public function update(Request $request, $id){
    // 
    $messages = [
      'required' => 'El título del formulario es un campo necesario',
      'image'    => 'El banner debe ser una imagen'
    ];
    // validate the title && file type
    $this->validate($request, [
      'survey-title'  => 'required|max:255',
      'survey-banner' => 'image'
    ], $messages);

    //
    if ($request->hasFile('survey-banner')) {
      $img = Image::make($request->file("survey-banner"))->widen(2560, function ($constraint) {
        $constraint->upsize();
      })->save(public_path() . '/img/programas/' . uniqid() . "." . $request->file("survey-banner")->guessExtension());
    }
  }

  //
  // [ E D I T O R ]
  //
  //
  public function blueprint($id){
    $user = Auth::user();
    $blueprint = $user->level == 3 ? Blueprint::with(["questions.options", "rules.question"])->find($id) : $user->blueprints->with(with(["questions.options", "rules.question"]))->find($id);

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
    $data['status']    = session('status');
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
