<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

use App\User;
use App\Models\Blueprint;
use App\Models\Authorization;

class Authorizations extends Controller
{
  public function __construct(){
    $user = Auth::user();
    if($user->level == 3) return redirect('dashboard');
  } 

  public function index(){
    $user = Auth::user();
    $data = [];

    $data['title']          = 'Autorizaciones';
    $data['description']    = '';
    $data['body_class']     = 'authorizations';
    $data['authorizations'] = Authorization::all();
    $data['user']           = $user;
    $data['status']         = session('status');
    return view("authorizations")->with($data);
  }
}
