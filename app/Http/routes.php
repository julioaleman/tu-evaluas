<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', "Frontend@index");

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// FRONT END
Route::get('que-es', "Frontend@about");
Route::get('preguntas-frecuentes', "Frontend@faqs");
Route::get('resultados', "Frontend@results");
Route::get("el-csv-para-preguntas", "Frontend@blueprintDocsCSV");



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
  // LOGIN & DASHBOARD
  Route::auth();
  Route::get('home', 'HomeController@index');
  Route::get('dashboard', 'HomeController@index');

  Route::group(['middleware' => 'auth'], function () {
    // USERS CRUD
    Route::get('dashboard/usuarios', 'Users@index');
    Route::post('dashboard/usuarios/crear', 'Users@store');
    Route::get('dashboard/usuario/{id}', 'Users@update');
    Route::post('dashboard/usuario/{id}', 'Users@change');

    // BLUEPRINT CRUD
    Route::get('dashboard/encuestas', 'Blueprints@index');
    Route::get('dashboard/encuestas/{id}', 'Blueprints@blueprint')->where('id', '[0-9]+');;
    Route::post('dashboard/encuestas/crear', 'Blueprints@create');
    Route::get('dashboard/encuestas/eliminar/{id}', 'Blueprints@delete')->where('id', '[0-9]+');

    // FILE GENERATOR
    Route::post('dashboard/encuestas/crear/csv', 'FromFileMake@questions');

    // BLUEPRINT JS API
    Route::post('dashboard/preguntas', 'BlueprintApi@saveQuestion');
    Route::get('dashboard/preguntas/{id}', 'BlueprintApi@getQuestion');
    Route::put('dashboard/preguntas/{id}', 'BlueprintApi@updateQuestion');
    Route::delete('dashboard/preguntas/{id}', 'BlueprintApi@deleteQuestion');
  });
});
