<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use League\Csv\Reader;

use App\User;
use App\Models\Blueprint;
use App\Models\Question;

class FromFileMake extends Controller
{
  public function index(){

    //
  }

  public function questions(Request $request){
    // [1] validate the title and the CSV
    $this->validate($request, [
        'title' => 'bail|required|max:255',
        'photo' => 'required|mimes:csv'
    ]);

    // [2] save the quiz blueprint
    $user = Auth::user();
    $blueprint             = new Blueprint;
    $blueprint->title      = $request->input("title");
    $blueprint->user_id    = $user->id;
    $blueprint->is_closed  = 0;
    $blueprint->is_public  = 0;
    $blueprint->is_visible = 1;
    $blueprint->save();

    // [3] add the questions
    $file = $request->file("the-csv");
    $reader = Reader::createFromPath($file->getPathName());
    $keys = ["id","question","section","type","answers"];
    $results = $reader->fetchAssoc($keys);
    foreach($results as $q){
      /*

  id             | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| section_id     | int(11)          | NO   |     | NULL    |                |
| blueprint_id   | int(11)          | NO   |     | NULL    |                |
| question       | text             | YES  |     | NULL    |                |
| is_description | tinyint(1)       | NO   |     | 0       |                |
| is_location    | tinyint(1)       | NO   |     | 0       |                |
| type           | varchar(255)     | YES  |     | NULL    |                |
| order_num      | int(11)          | YES  |     | NULL    |                |
| default_value  | int(11)          | YES  |     | NULL    |                |
| created_at     | timestamp        | YES  |     | NULL    |                |
| updated_at     | timestamp        | YES  |     | NULL    |                |
| local_id       | varchar(255)     | YES  |     | NULL    |                |
      */
      $question = new Question;
      $options  = $q['section'] ? 
      $question->blueprint_id = $blueprint->id;
      $question->local_id     = $q['id'];
      $question->question     = $q['question'];
      $question->section_id   = $q['section'] ? $q['section'] : 1;
      if($q['section']){

      }
    }
  }
}
