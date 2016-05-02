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
use Artisan;

class Blueprints extends Controller
{
  const PAGE_SIZE = 50;

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
  // [ S E A R C H ]
  //
  //
  function searchBlueprints(Request $request, $page = 1){
    $user = Auth::user();

    if(empty($request->all())){
      if($user->level == 3){
        $blueprints = Blueprint::skip(($page-1) * self::PAGE_SIZE)->take(self::PAGE_SIZE)->get();
        $total      = Blueprint::count();
      }
      else{
        $blueprints = $user->blueprints()->skip(($page-1) * self::PAGE_SIZE)->take(self::PAGE_SIZE)->get();
        $total      = $user->blueprints()->count();
      }
    }
    else{
      if($user->level == 3){
        $blueprints = $this->_search($request)
                    ->skip(($page-1) * self::PAGE_SIZE)
                    ->take(self::PAGE_SIZE)
                    ->get();
        $total      = $this->_search($request)->count();
      }else{
        $blueprints = $this->_search($request)
                    ->skip(($page-1) * self::PAGE_SIZE)
                    ->take(self::PAGE_SIZE)
                    ->where("user_id", $user->id)
                    ->get();
        $total      = $this->_search($request)->where("user_id", $user->id)->count();
      }
    }

    $categories = file_get_contents(public_path() . "/". "js/categories.json");
    $data = [];
    $data['surveys']     = $blueprints;
    $data['title']       = 'Resultados | Tú Evalúas';
    $data['description'] = 'Resultados de cuestionarios en Tú Evalúas';
    $data['body_class']  = 'advanced-search';
    $data['categories']  = collect(json_decode($categories));
    $data['request']     = $request;
    $data['page']        = $page;
    $data['total']       = $total;
    $data['user']        = $user;
    $data['pages']       = ceil($total/self::PAGE_SIZE);


    return view("blueprint-search")->with($data);
  }

  //
  // [ S E A R C H   Q U E R Y ]
  //
  //
  private function _search($request){
    $title       = $request->input("title", null);
    $category    = $request->input("category", null);
    $survey_subs = $request->input("survey-subs", null);
    $tags        = $request->input("survey-tags", null);

    $query = Blueprint::where(function($q) use($request, $title, $category, $tags, $survey_subs){
      // search title
      if(!empty($title)){
        //$q->where("title", "like", "%". $request->input("title") . "%");
        $q->where(function($query) use($title){
            $query->where("title", "like", "%{$title}%")
            ->orWhere("category", "like", "%{$title}%")
            ->orWhere("subcategory", "like", "%{$title}%")
            ->orWhere("branch", "like", "%{$title}%")
            ->orWhere("unit", "like", "%{$title}%")
            ->orWhere("tags", "like",  "%{$title}%");
        });
      }
        // search category
      if(!empty($category)){
        echo "zzzzzzzzzzzzzzzzz";
        $q->where("category", $request->input("category"));
      }
      // search subcategory
      if(!empty($survey_subs)){
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
      if(!empty($tags)){
        $tags = $request->input("survey-tags");
        $q->where(function($q) use($tags){
          $first = array_shift($tags);
          $q->where("tags", "like", "%" . $first . "%");
          foreach($tags as $tag){
            $q->orWhere("tags", "like", "%" . $tag . "%");
          }
        });
      }
    });

    return $query;
  }

  //
  // [ L A N D I N G   C R E A T E ]
  //
  //
  public function addBlue(Request $request){
	$user = Auth::user();
	$data = [];

    $data['title']       = 'Encuestas Tú Evalúas';
    $data['description'] = '';
    $data['body_class']  = 'surveys';
    $data['user']        = $user;
    $data['status']      = session('status');

    return view("add_blueprints")->with($data);
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
    $blueprint->is_visible = 0;
    $blueprint->type      = "regular";
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
      $path = "/csv/";
      $request->file('the-results-file')->move(public_path() . $path, $name);

      $blueprint             = new Blueprint;
      $blueprint->user_id    = $user->id;
      $blueprint->title      = $request->input('title');
      $blueprint->is_public  = 0;
      $blueprint->is_visible = 0;
      $blueprint->is_closed  = 1;
      $blueprint->type       = "results";
      $blueprint->csv_file   = $name;
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
    $blueprint = $user->level == 3 ? Blueprint::find($id) : Blueprint::where("user_id",$user->id)->find($id);

    //
    if(!$blueprint) return redirect("dashboard/encuestas");

    //

    $blueprint->title       = $request->input("survey-title");
    $blueprint->category    = $request->input("survey-category");
    $blueprint->subcategory = $request->input("survey-subs", null) ? implode(",", $request->input("survey-subs")) : "";
    $blueprint->tags        = $request->input("survey-tags", null) ? implode(",", $request->input("survey-tags")) : "";
    //  $blueprint->is_public   = $request->input("is_public") ? 1 : 0; 
    //  $blueprint->is_closed   = $request->input("is_closed") ? 1 : 0; 
    $blueprint->banner      = isset($name) ? $name : $blueprint->banner;
    $blueprint->ptp         = $request->input("survey-ptp", null);
    $blueprint->description = $request->input("survey-description", null);
    // $blueprint->unit        = $request->input("survey-unit", null);
    $blueprint->branch      = $request->input("survey-branch", null);
    $blueprint->program     = $request->input("survey-program", null);
    $blueprint->save();

    //
    $request->session()->flash('status', ['type' => 'update', 'name' => $blueprint->title]);
    return redirect("dashboard/encuesta/" . $blueprint->id);
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

    $blueprint->is_public  = 0;
    $blueprint->is_visible = 0;
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
  public function confirmAuthBlueprint(Request $request, $id, $single = false){
    $user = Auth::user();
    if($user->level == 3){
      $blueprint = Blueprint::find($id);
      $blueprint->is_public  = 1;
      $blueprint->is_visible = 1;
      $blueprint->pending    = 0;
      $blueprint->is_closed  = 0;
      $blueprint->update();
      $request->session()->flash('status', ['type' => 'authorize create', 'name' => $blueprint->title]);
    }
    if($single){
      return redirect("dashboard/encuesta/" . $id);
    }
    else{
      return redirect("dashboard/encuestas/");
    }
  }

  //
  // [ F I N I S H   B L U E P R I N T ]
  //
  //
  public function closeAuthBlueprint(Request $request, $id, $single = false){
    $user = Auth::user();
    if($user->level == 3){
      $blueprint = Blueprint::find($id);
      $blueprint->is_public  = 0;
      $blueprint->is_visible = 1;
      $blueprint->is_closed  = 1;
      $blueprint->pending    = 0;
      $blueprint->update();
      $request->session()->flash('status', ['type' => 'finish create', 'name' => $blueprint->title]);
    }
    if($single){
      return redirect("dashboard/encuesta/" . $id);
    }
    else{
      return redirect("dashboard/encuestas/");
    }
  }

  //
  // [ H I D E   B L U E P R I N T ]
  //
  //
  public function hideAuthBlueprint(Request $request, $id){
    $user = Auth::user();
    if($user->level == 3){
      $blueprint = Blueprint::find($id);
      $blueprint->is_visible = 0;
      $blueprint->update();
      $request->session()->flash('status', ['type' => 'hide create', 'name' => $blueprint->title]);
    }

    return redirect("dashboard/encuesta/" . $id);
  }

  //
  // [ S H O W   B L U E P R I N T ]
  //
  //
  public function showAuthBlueprint(Request $request, $id){
    $user = Auth::user();
    if($user->level == 3){
      $blueprint = Blueprint::find($id);
      $blueprint->is_visible = 1;
      $blueprint->update();
      $request->session()->flash('status', ['type' => 'show create', 'name' => $blueprint->title]);
    }

    return redirect("dashboard/encuesta/" . $id);
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
    $blueprint = Blueprint::find($id);
    $path      = base_path();

    if($user->level != 3) die("n______n");

    exec("php {$path}/artisan blueprint:file {$id} xlsx > /dev/null &");
    exec("php {$path}/artisan blueprint:file {$id} csv > /dev/null &");
    
    $request->session()->flash('status', ['type' => 'file create', 'name' => $blueprint->title]);
    return redirect("dashboard/encuesta/" . $id);
  }

  //
  // [ S E A R C H - J S O N ]
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

  //
  // [ M A K E   S L U G ]
  //
  //
  // http://stackoverflow.com/questions/5305879/automatic-clean-and-seo-friendly-url-slugs
  private function sluggable($string, $separator = '-') {
    $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
    $special_cases = array( '&' => 'and', "'" => '');
    $string = mb_strtolower( trim( $string ), 'UTF-8' );
    $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
    $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
    $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
    $string = preg_replace("/[$separator]+/u", "$separator", $string);
    return $string;
  }
}
