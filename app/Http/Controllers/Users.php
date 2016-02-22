<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\User;
use App\models\Blueprint;

class Users extends Controller
{
  public function index(){
    $user   = Auth::user();
    $admins = User::where("level", 3)->get(); 
    $users  = User::where("level", 2)->get(); 

    $data = [];
    $data['title']       = 'Admins Tú Evalúas';
    $data['description'] = '';
    $data['body_class']  = 'users';
    $data['user']        = $user;
    $data['users']       = $users;
    $data['admins']      = $admins;
    $data['status']      = session('status');

    return view("users")->with($data);
  }

  public function store(Request $request){
  }

  public function update($id = false){
  }
}
