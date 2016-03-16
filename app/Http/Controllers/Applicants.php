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
    $data['body_class']  = 'cuestionarios';
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

  public function makeFile(Request $request){
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
    $data['answers']   = [];
    $data['is_test']   = false;
    return view("real-form")->with($data);
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
