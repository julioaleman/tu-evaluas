<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\User;
use App\Models\Blueprint;
use Image;
use League\Csv\Reader;
use League\Csv\Writer;
use Excel;

class Blueprints extends Controller
{
  //
  // [ L I S T ]
  //
  //
  public function index(Request $request, $type = "todas", $page = 1){
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
      'title' => 'required'
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

    return redirect('dashboard/encuesta/' . $blueprint->id);
  }

  //
  // [ C R E A T E   F I N I S H E D ]
  //
  //
  public function createResultsOnly(Request $request){
    $messages = [
      'title.required'            => 'El título del formulario es un campo necesario',
      'the-results-file.required' => 'Es necesario subir el archivo con los resultados',
    ];
    // validate the title && file type
    $this->validate($request, [
      'title'            => 'required',
      'the-results-file' => 'required'
    ], $messages);

    //
    if($request->file('the-results-file')->isValid()){
      $user = Auth::user();
      $name = uniqid() . "." . $request->file("the-results-file")->guessExtension();
      $path = "/results/";
      $request->file('the-results-file')->move(public_path() . $path, $name);

      $blueprint            = new Blueprint;
      $blueprint->user_id   = $user->id;
      $blueprint->title     = $request->input('title');
      $blueprint->is_public = 0;
      $blueprint->is_closed = 1;
      $blueprint->type      = "results";
      $blueprint->csv_file  = $name;
      $blueprint->save();

      $request->session()->flash('status', ['type' => 'create', 'name' => $blueprint->title]);
      return redirect('dashboard/encuesta/' . $blueprint->id);
    }
    else{
      $request->session()->flash('status', ['type' => 'create-fail', 'name' => $request->input('title')]);
      return redirect("dashboard/encuestas");
    }
  }

  //
  // [ U P D A T E   B L U E P R I N T ]
  //
  //
  public function update(Request $request, $id){
    $messages = [
      'survey-title.required' => 'El título del formulario es un campo necesario',
      'survey-banner.image'   => 'La portada debe ser un archivo de tipo imagen',
    ];
    // validate the title && file type
    $this->validate($request, [
      'survey-title'  => 'required',
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
    $blueprint->ptp         = $request->input("survey-ptp");
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
    $blueprint = $user->level == 3 ? Blueprint::with(["questions.options", "rules"])->find($id) : Blueprint::with(["questions.options", "rules"])->where("user_id",$user->id )->find($id);

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
  public function remove(Request $request, $id){
    $user = Auth::user();
    $blueprint = Blueprint::find($id);
    if($blueprint && ($user->level == 3 || $user->id == $blueprint->user_id)){
      $title = $blueprint->title;

      $blueprint->questions()->delete();
      $blueprint->options()->delete();
      $blueprint->rules()->delete();
      $blueprint->delete();

      $request->session()->flash('status', ['type' => 'delete', 'name' => $title]);
      return redirect('dashboard/encuestas');
    }
    else{
      return redirect('dashboard/encuestas');
    }
  }

  //
  // [ H I D E ]
  //
  //
  public function hideBlueprint(Request $request, $id){
    $user = Auth::user();
    $blueprint = $user->blueprints()->find($id);
    if(! $blueprint) return redirect("dashboard/encuestas");

    $blueprint->is_public = 0;
    $blueprint->update();

    $request->session()->flash('status', ['type' => 'update', 'name' => $blueprint->title]);

    return redirect("dashboard/encuesta/" . $blueprint->id);
  }

  //
  // [ A U T H O R I Z E ]
  //
  //
  public function authBlueprint(Request $request, $id){
    $user = Auth::user();
    $blueprint = $user->blueprints()->find($id);
    if(! $blueprint) return redirect("dashboard/encuestas");

    $blueprint->pending = 1;
    $blueprint->update();

    $request->session()->flash('status', ['type' => 'authorize', 'name' => $blueprint->title]);
    return redirect("dashboard/encuesta/" . $blueprint->id);
  }

  //
  // [ C O N F I R M   A U T H O R I Z A T I O N ]
  //
  //
  public function confirmAuthBlueprint(Request $request, $id){
    $user = Auth::user();
    if($user->level == 3){
      $blueprint = Blueprint::find($id);
      $blueprint->is_public = 1;
      $blueprint->pending = 0;
      $blueprint->update();
      $request->session()->flash('status', ['type' => 'authorize', 'name' => $blueprint->title]);
    }
    return redirect("dashboard/encuestas/");
  }

  //
  // [ C A N C E L   A U T H O R I Z A T I O N ]
  //
  //
  public function cancelAuth(Request $request, $id){
    $user = Auth::user();
    $blueprint = $user->blueprints()->find($id);
    if(! $blueprint) return redirect("dashboard/encuestas");

    $blueprint->pending = 0;
    $blueprint->update();

    $request->session()->flash('status', ['type' => 'cancel', 'name' => $blueprint->title]);
    return redirect("dashboard/encuesta/" . $blueprint->id);
  }

  //
  // [ E X P O R T   C S V ]
  //
  //
  public function makeCSV(Request $request, $id){
    $user      = Auth::user();
    $blueprint = Blueprint::with("questions.options")->find($id);
    //$questions = $blueprint->questions;
    //$titles    = $questions->pluck("question");
    
    Excel::create('resultados', function($excel) use($blueprint) {
      // Set the title
      $excel->setTitle($blueprint->title);
      // Chain the setters
      $excel->setCreator('Tú Evalúas');
      //->setCompany('Transpar');
      // Call them separately
      $excel->setDescription("Resuktadis dsagregados");
        // add a sheet for each day, and set the date as the name of the sheet
      $excel->sheet("encuestas", function($sheet) use($blueprint){
        //var_dump($titles->toArray());
        $questions = $blueprint->questions;
        $titles    = $questions->pluck("question");

        $sheet->appendRow($titles->toArray());

        $applicants = $blueprint->applicants()->has("answers")->with("answers")->get();

        foreach($applicants as $applicant){
          $row  = [];
          foreach($questions as $question){
            if($question->is_description){
              $row[] = "es descripción";
            }
            elseif($question->is_location){
              $inegi_key = $applicant
                       ->answers()
                       ->where("question_id", $question->id)
                       ->get()
                       ->first();//->text_value;
              $row[] = $inegi_key ? $inegi_key->text_value : "no dijo de dónde";
            }
            elseif($question->type == "text"){
              $open_answer = $applicant
                       ->answers()
                       ->where("question_id", $question->id)
                       ->get()
                       ->first();//->text_value;
              $row[] = $open_answer ? $open_answer->text_value : "no contestó";
            }
            elseif($question->options->count()){
              $row[] = "es opción múltiple";
            }
            else{
              $num_value = $applicant
                       ->answers()
                       ->where("question_id", $question->id)
                       ->get()
                       ->first();//->text_value;
              $row[] = $num_value ? $num_value->num_value : "-";
            }
          }
          $sheet->appendRow($row);
        }
      });
    })->store("csv", public_path('csv'));
  }

  //
  // [ S E A R C H ]
  //
  //
  public function search(Request $request){
    $user = Auth::user();
    $query = $request->input("query");
    if($user->level == 3){
      $response = Blueprint::where("title", "like", "%{$query}%")->get();
    }
    else{
      $response = $user->blueprints()->where("title", "like", "%{$query}%")->get();
    }
    return response()->json($response)->header('Access-Control-Allow-Origin', '*');
  }
}
