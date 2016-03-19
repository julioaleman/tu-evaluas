<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Mailgun\Mailgun;
use Mail;
use League\Csv\Writer;
use League\Csv\Reader;
use Excel;
use Auth;

use App\User;
use App\Models\Blueprint;
use App\Models\Applicant;
use App\Models\City;
use App\Models\Location;
use App\Models\Answer;
use App\Models\Question;

class Applicants extends Controller
{
  /*
  * A D M I N   V I E W
  * --------------------------------------------------------------------------------
  */

  // 
  // [ OPTIONS FOR SUBMIT FORMS ]
  //
  //
  public function index(){
    $user = Auth::user();
    $blueprints = $user->level == 3 ? Blueprint::with("applicants")->get() : Blueprint::with("applicants")->where("user_id",$user->id )->get();
   
    $data['title']       = 'Encuestas por aplicar Tú Evalúas';
    $data['description'] = '';
    $data['body_class']  = 'applicants';
    $data['user']        = $user;
    $data['blueprints']  = $blueprints;

    return view("applicants")->with($data);
  }

  /*
  * M U L T I P L E   F U N C T I O N S
  * --------------------------------------------------------------------------------
  */

  //
  // [ SEND ONE INVITATION ]
  //
  //
  public function mailto(Request $request){
    $user      = Auth::user();
    $creator   = $user->id;
    $blueprint = Blueprint::find($request->input('id'));
    $email     = $request->input("email");
    $form_key  = md5('blueprint' . $blueprint->id . $email);

    $applicant = Applicant::firstOrCreate([
      "blueprint_id" => $blueprint->id, 
      "form_key"     => $form_key, 
      "user_email"   => $email
      ]);
    $this->sendForm($applicant);
    return redirect('dashboard/encuestados');
  }

  //
  // [ CREATE A FILE WITH A LIST OF APPLICANT KEYS ]
  //
  //
  public function makeFile(Request $request){
    $user      = Auth::user();
    $blueprint = Blueprint::find($request->input('id'));
    $total     = $request->input('total', null) ? $request->input('total') : 1;
    $type      = $request->input('type', null) ? $request->input('type') : "csv";

    $options = [
      'user'      => $user,
      "blueprint" => $blueprint,
      "total"     => $total,
      "type"      => $type
    ];

    Excel::create('encuestas', function($excel) use($options) {
      // Set the title
      $excel->setTitle("encuestas");
      // Chain the setters
      $excel->setCreator('Tú Evalúas');
      //->setCompany('Transpar');
      // Call them separately
      $excel->setDescription("Lista de links a encuestas");
        // add a sheet for each day, and set the date as the name of the sheet
      $excel->sheet("encuestas", function($sheet) use($options){
        foreach($this->makeRange($options['total']) as $i){
          $form_key = md5('blueprint' . $options['blueprint']->id . uniqid($i));
          
          $applicant = Applicant::firstOrCreate([
            "blueprint_id" => $options['blueprint']->id, 
            "form_key"     => $form_key, 
            "user_email"   => ""
          ]);

          $sheet->appendRow([
            "id"    => $applicant->id, 
            "clave" => $applicant->form_key, 
            "url"   => url('encuesta/' . $applicant->form_key)
          ]);
        }
      }); // add a sheet for each day ends

    })->export($type);
  }

  function sendEmails(Request $request){
    if (! $request->hasFile('list')) return redirect("dashboard/encuestados");

    $user      = Auth::user();
    $creator   = $user->id;
    $blueprint = Blueprint::find($request->input('id'));
    $file     = $request->file("list");
    $fileUrl = $file->getPathName(); //. '/' . $file->getClientOriginalName();

    $reader = Reader::createFromPath($fileUrl);
    $results = $reader->fetch();

    // fake limit 
    $limit   = 5;
    $counter = 0;

    foreach ($results as $row) {
      $form_key  = md5('blueprint' . $blueprint->id . $row[0]);
      $applicant = Applicant::firstOrCreate([
        "blueprint_id" => $blueprint->id, 
        "form_key"     => $form_key, 
        "user_email"   => $row[0]
      ]);
      if($counter > $limit) break;
      $this->sendForm($applicant);
      $counter++;
    }

    return redirect('dashboard/encuestados');
  }

  /*
  * F R O N T   E N D
  * --------------------------------------------------------------------------------
  */

  //
  // [ DISPLAY FORM ]
  //
  //
  public function displayForm($form_key){
    $applicant = Applicant::where("form_key", $form_key)->first();
    $blueprint = $applicant->blueprint; 

    $data = [];
    $data['applicant'] = $applicant;
    $data['blueprint'] = $blueprint;
    $data['questions'] = $blueprint->questions;
    $data['rules']     = $blueprint->rules;
    $data['options']   = $blueprint->options;
    $data['answers']   = Answer::where("form_key", $form_key)->get();
    $data['is_test']   = false;
    return view("real-form")->with($data);
  }

  //
  // [ SAVE ANSWER ]
  //
  //
  public function saveAnswer(Request $request){
    $applicant = Applicant::where('form_key', $request->input('form_key'))->first();
    $blueprint = Blueprint::find($applicant->blueprint_id);
    $question  = Question::find($request->input('question_id'));

    $answer = Answer::firstOrCreate([
      "blueprint_id" => $blueprint->id,
      "question_id"  => $question->id,
      "form_key"     => $applicant->form_key
    ]);

    $answer->text_value = $question->type == "text" ? $request->input('question_value') : null;
    $answer->num_value  = $question->type == "integer" || "number" ? $request->input('question_value') : null;

    $answer->update();
    $answer->question_value = $request->input('question_value');

    return response()->json($answer)->header('Access-Control-Allow-Origin', '*');
  }

  //
  // [ SEND CITIES ]
  //
  //
  public function cities($state_id){
    $cities = City::where("estado_id", $state_id)->get();
    return response()->json($cities)->header('Access-Control-Allow-Origin', '*');
  }

  //
  // [ SEND LOCATIONS ]
  //
  //
  public function locations($state_id, $city_key){
    $city = City::where("estado_id", $state_id)->where("clave", $city_key)->first();
    $locations = Location::where("municipio_id", $city->id)->get();
    return response()->json($locations)->header('Access-Control-Allow-Origin', '*');
  }

  /*
  * G E N E R A L   F U N C T I O N S
  * --------------------------------------------------------------------------------
  */

  //
  // [ SEND MAIL WITH MAILGUN ]
  //
  //
  public function sendForm($applicant){
    Mail::send('email.invitation', ['applicant' => $applicant], function ($m) use ($applicant) {
      $m->from('howdy@tuevaluas.com.mx', 'Howdy friend');
      $m->to($applicant->user_email, "amigo")->subject('Invitación a opinar!');
    });
  }

  //
  // [ OPTIMIZE RAM WITH A GENERATOR ]
  //
  //
  private function makeRange($length) {
    for ($i = 0; $i < $length; $i++) {
        yield $i;
    }
  }
}
