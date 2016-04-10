<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use League\Csv\Reader;
use Excel;

use App\User;
use App\Models\Blueprint;
use App\Models\Question;
use App\Models\Option;

class FromFileMake extends Controller
{
  public function index(){

    //
  }

  public function questions(Request $request){
    // [1] validate the title and the CSV
    $this->validate($request, [
        'title'   => 'bail|required|max:255',
        'the-csv' => 'required'
    ]);
    

    // [2] save the quiz blueprint
    $user = Auth::user();
    $blueprint             = new Blueprint;
    $blueprint->title      = $request->input("title");
    $blueprint->user_id    = $user->id;
    $blueprint->is_closed  = 0;
    $blueprint->is_public  = 0;
    $blueprint->is_visible = 1;
    $blueprint->type       = "generated";
    $blueprint->save();

    // [3] add the questions
    $file = $request->file("the-csv");
    $temp = $file->getPathName();

    Excel::load($temp, function($reader) use($blueprint){
      $reader->each(function($row) use($blueprint){
        if(trim($row->pregunta) != "" ){
          $question = new Question;
          //$options  = !empty($row->seccion) ? (int)$row->seccion : 1;
          $question->blueprint_id = $blueprint->id;
          $question->question     = $row->pregunta;
          $question->section_id   = !empty($row->seccion) ? (int)$row->seccion : 1;
          
          $question = $this->set_type($question, $row);

          $question->save();
        }

        /*
      // [4] add the options if required
      if(!empty($q['options'])){
        $options = explode("|", $q['options']);
        for($i = 0; $i < count($options); $i++){
          $option = new Option;
          $option->question_id  = $question->id;
          $option->blueprint_id = $blueprint->id;
          $option->description  = $options[$i];
          $option->value        = $i+1;
          $option->name         = uniqid();
          $option->order_num    = $i;
          $option->save();
        } // for
      } // if
      */
      });
    })->first();
    
    
    
    $request->session()->flash('status', ['type' => 'create', 'name' => $blueprint->title]);
    return redirect("dashboard/encuestas");
  } // function

  private function set_type($question, $data){
    if($data->tipo == "abierta"){
      $question->type == "string";
    }
    else{
      $question->type == "integer";
    }

    return $question;
  }


}
