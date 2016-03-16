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
    // 
    $messages = [
      'required' => 'El título del formulario es un campo necesario'
    ];

    // validate the title
    $this->validate($request, [
      'title' => 'required|max:255'
    ], $messages);

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
    // validate the title && file type
    $this->validate($request, [
      'survey-title'  => 'required|max:255',
      'survey-banner' => 'image'
    ]);

    //
    if ($request->hasFile('survey-banner')) {
      $name = uniqid() . "." . $request->file("survey-banner")->guessExtension();
      $path = "/img/programas/";
      $img  = Image::make($request->file("survey-banner"))->widen(2560, function ($constraint) {
        $constraint->upsize();
      })->save(public_path() . $path . $name);
    }

    //
    $user = Auth::user();
    $blueprint = $user->level == 3 ? Blueprint::with(["questions.options", "rules.question"])->find($id) : Blueprint::with(["questions.options", "rules.question"])->where("user_id",$user->id )->find($id);

    //
    if(!$blueprint) return redirect("dashboard/encuestas");

    //

    $blueprint->title       = $request->input("survey-title");
    $blueprint->category    = $request->input("survey-category");
    $blueprint->subcategory = $request->input("survey-subs", null) ? implode(",", $request->input("survey-subs")) : "";
    $blueprint->tags        = $request->input("survey-tags", null) ? implode(",", $request->input("survey-tags")) : "";
    $blueprint->is_public   = $request->input("is_public") ? 1 : 0; 
    $blueprint->is_closed   = $request->input("is_closed") ? 1 : 0; 
    $blueprint->banner      = isset($name) ? $name : $blueprint->banner;
    $blueprint->save();

    //
    $request->session()->flash('status', ['type' => 'update', 'name' => $blueprint->title]);
    return redirect("dashboard/encuestas/" . $blueprint->id);
  }

  //
  // [ E D I T O R ]
  //
  //
  public function blueprint($id){
    $user = Auth::user();
    $blueprint = $user->level == 3 ? Blueprint::with(["questions.options", "rules"])->find($id) : Blueprint::with(["questions.options", "rules"])->where("user_id",$user->id )->find($id);

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
  // [ S I M U L A T O R ]
  //
  //
  public function show($id){
    $user = Auth::user();
    $blueprint = $user->level == 3 ? Blueprint::with(["questions.options", "rules.question"])->find($id) : Blueprint::with(["questions.options", "rules.question"])->where("user_id",$user->id )->find($id);

    if(!$blueprint) die("Este formulario no existe!");

    $data = [];
   
    $data['applicant'] = $user;
    $data['blueprint'] = $blueprint;
    $data['questions'] = $blueprint->questions;
    $data['rules']     = $blueprint->rules;
    $data['options']   = $blueprint->options;
    $data['answers']   = [];
    $data['is_test']   = true;
    return view("test-form")->with($data);
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

      $blueprint->questions->delete();
      $blueprint->options->delete();
      $blueprint->rules->delete();
      $blueprint->delete();

      $request->session()->flash('status', ['type' => 'delete', 'name' => $title]);
      return redirect('dashboard/encuestas');
    }
    else{
      return redirect('dashboard/encuestas');
    }
  }

  //
  // [ S E A R C H ]
  //
  //
  public function search(Request $request){
    $query = $request->input("query");
    $response = Blueprint::where("title", "like", "%{$query}%")->get();
    return response()->json($response)->header('Access-Control-Allow-Origin', '*');
  }
}
