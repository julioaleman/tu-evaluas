<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Mailgun\Mailgun;
use League\Csv\Writer;
use League\Csv\Reader;
use Auth;

use App\User;
use App\Models\Blueprint;
use App\Models\Applicant;

class Applicants extends Controller
{
  public function index(){
    $user = Auth::user();
    $blueprints = $user->level == 3 ? Blueprint::all() : $user->blueprints;
   
    $data['title']       = 'Encuestas por aplicar Tú Evalúas';
    $data['description'] = '';
    $data['body_class']  = 'cuestionarios';
    $data['user']        = $user;
    $data['blueprints']  = $blueprints;

    //return view("")->with($data);
  }

  public function mailto(Request $request, $id){
    $user = Auth::user();
    $creator   = $user->id;
    $blueprint = Blueprint::find($id);
    $email     = $request->input("email");

    $form_key = md5('blueprint' . $id . $email);

    $applicant = Applicant::firstOrCreate(["blueprint_id" => $blueprint->id, "form_key" => $form_key, "form_key", "email" => $email]);
    $this->mailgun_library->survey_invitation($email, $form_key, $blueprint->title);
    //redirect('bienvenido/cuestionarios');
  }

  public function sendForm($applicant){
    $from    = "howdy@tuevaluas.com.mx";
    $subject = "Invitación a opinar";
    $to      = $applicant->email;
    $mailgun = new Mailgun (env('MAILGUN_KEY'));

    $message = [
      'from'    => $from,
      'to'      => $to,
      'subject' => $subject,
      'html'    => view('emails.message')->with(["applicant" => $applicant])
    ];
    
    $mailgun->sendMessage(env('MAILGUN_DOMAIN'), $message);
  }

  private function makeRange($length) {
    for ($i = 0; $i < $length; $i++) {
        yield $i;
    }
  }
}
