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
    $r    = $request->all();
    $file = $request->file("the-csv");
    $reader = Reader::createFromPath($file->getPathName());
    
    foreach($reader as $el){
      echo "<pre>";
      var_dump($el);
      echo "</pre>";
    }
    //var_dump($file);
  }
}
