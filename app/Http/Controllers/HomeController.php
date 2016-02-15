<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

use App\User;
use App\models\Blueprint;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user                = Auth::user();

      $data['title']       = 'Dashboard Tú Evalúas';
      $data['description'] = '';
      $data['body_class']  = 'dash';
      $data['user']        = $user;
      $data['admins']      = $user->level == 3 ? User::all() : [];
      $data['surveys']     = $user->level == 3 ? Blueprint::all() : $user->blueprints;

      return view('dashboard')->with($data);
    }
}
