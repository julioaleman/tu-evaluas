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
  // FRONT END
  Route::get('que-es', "Frontend@about");
  Route::get('preguntas-frecuentes', "Frontend@faqs");
  Route::get('resultados/{page?}', "Frontend@results");
  Route::get('resultado/{id}', "Frontend@result")->where('id', '[0-9]+');

  Route::get('terminos-condiciones', "Frontend@terms");
  Route::get('aviso-privacidad', "Frontend@privacy");
  Route::get('contacto', "Frontend@contact");

  Route::get("el-csv-para-preguntas", "Frontend@blueprintDocsCSV");

  // Password reset link request routes...
  Route::get('password/email', 'Auth\PasswordController@getEmail');
  Route::post('password/email', 'Auth\PasswordController@postEmail');

  // Password reset routes...
  Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
  Route::post('password/reset', 'Auth\PasswordController@postReset');

  // LOGIN & DASHBOARD
  Route::auth();
  Route::get('home', 'HomeController@index');
  Route::get('dashboard', 'HomeController@index');

  // FORM APPLY
  Route::get('encuesta/{key}', 'Applicants@displayForm');
  Route::get('encuesta/municipios/{id}', 'Applicants@cities');
  Route::get('encuesta/localidades/{estado}/{municipio}', 'Applicants@locations');
  Route::post('encuesta/respuestas', 'Applicants@saveAnswer');

  Route::group(['middleware' => 'auth'], function () {
    // USERS CRUD
    Route::get('dashboard/usuarios', 'Users@index');
    Route::post('dashboard/usuarios/crear', 'Users@store');
    Route::get('dashboard/usuario/{id}', 'Users@update');
    Route::post('dashboard/usuario/{id}', 'Users@change');
    Route::get('dashboard/usuario/eliminar/{id}', 'Users@delete');

    // FAKE FORM APPLY
    Route::post('dashboard/encuesta/test/respuestas', 'Applicants@saveAnswer');
    Route::get('dashboard/encuesta/test/municipios/{id}', 'Applicants@cities');
    Route::get('dashboard/encuesta/test/localidades/{estado}/{municipio}', 'Applicants@locations');

    // AUTHORIZATIONS
    Route::get('dashboard/autorizaciones', "Authorizations@index");
    Route::get('dashboard/encuestas/ocultar/{id}', "Blueprints@hideBlueprint");
    Route::get('dashboard/encuestas/autorizar/{id}', "Blueprints@authBlueprint");
    Route::get('dashboard/encuestas/cancelar/{id}', "Blueprints@cancelAuth");

    Route::get('dashboard/encuestas/autorizar/confirmar/{id}/{single?}', "Blueprints@confirmAuthBlueprint");
    Route::get('dashboard/encuestas/cerrar/confirmar/{id}/{single?}', "Blueprints@closeAuthBlueprint");
    Route::get('dashboard/encuestas/terminar/confirmar/{id}/{single?}', "Blueprints@finishAuthBlueprint");

    // SEARCH
    Route::get('dashboard/encuestas/buscar/json', 'Blueprints@search');
    Route::get('dashboard/usuarios/buscar/json', 'Users@search');
    
    // BLUEPRINT CRUD
    Route::get('dashboard/encuestas/crear/csv/{id}', 'Blueprints@makeCSV');
    Route::get('dashboard/encuesta/{id}', 'Blueprints@blueprint')->where('id', '[0-9]+');
    Route::post('dashboard/encuesta/{id}', 'Blueprints@update')->where('id', '[0-9]+');
    Route::get('dashboard/encuestas/agregar', 'Blueprints@addBlue');
    Route::post('dashboard/encuestas/crear', 'Blueprints@create');
    Route::post('dashboard/encuestas/resultados/crear', 'Blueprints@createResultsOnly');
    Route::get('dashboard/encuestas/eliminar/{id}', 'Blueprints@remove')->where('id', '[0-9]+');
    Route::get('dashboard/encuesta/test/{id}', 'Blueprints@show')->where('id', '[0-9]+');
    Route::get('dashboard/encuestas/{tipo?}/{page?}', 'Blueprints@index');


    // APPLICANTS
    Route::get('dashboard/encuestados', 'Applicants@index');
    Route::post('dashboard/encuestados/enviar/uno', 'Applicants@mailto');
    Route::post('dashboard/encuestados/enviar/todos', 'Applicants@sendEmails');
    Route::post('dashboard/encuestados/crear/archivo', 'Applicants@makeFile');


    // FILE GENERATOR
    Route::post('dashboard/encuestas/crear/csv', 'FromFileMake@questions');

    // BLUEPRINT JS API
    Route::post('dashboard/preguntas', 'BlueprintApi@saveQuestion');
    Route::get('dashboard/preguntas/{id}', 'BlueprintApi@getQuestion');
    Route::put('dashboard/preguntas/{id}', 'BlueprintApi@updateQuestion');
    Route::delete('dashboard/preguntas/{id}', 'BlueprintApi@deleteQuestion');

    Route::post('dashboard/reglas', 'BlueprintApi@saveRule');
    Route::delete('dashboard/reglas/{id}', 'BlueprintApi@deleteRule');

  });
});
