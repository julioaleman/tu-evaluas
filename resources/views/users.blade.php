<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="es" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{$title}}</title>
  <meta name="description" content="{{$description}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{url('img/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/normalize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/styles.css')}}">

    <!-- NEW CSS -->
    <link rel="stylesheet" type="text/css" href="{{url('js/bower_components/sweetalert/dist/sweetalert.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/dev.css')}}">
</head>
<body class="backend">

<header class="pg">
  <div class="clearfix">
    <nav class="col-sm-3 col-sm-offset-1">
      <a href="{{url('/')}}" class="tuevaluas">Tú evalúas</a>
    </nav>
    <nav class="col-sm-1 col-sm-offset-7">
      <ul>
        <li><a href="{{url('logout')}}">Salir</a></li>
      </ul>
    </nav>
  </div>  
</header> 
<nav class="nav_back">
  <div class="container">
    <div class="row">
        <ul>
        <li class="{{$body_class == 'dash' ? 'current' : ''}}">
          <a href="{{url('dashboard')}}">Dashboard</a>
        </li>

          <li class="{{$body_class == 'surveys' ? 'current' : ''}}">
            <a href="{{url('dashboard/encuestas')}}">Encuestas</a>
          </li>

          <li class="{{$body_class == 'users' ? 'current' : ''}}">
            @if($user->level == 3)
            <a href="{{url('dashboard/usuarios')}}">Usuarios</a>
            @else
            <a href="{{url('dashboard/perfil')}}">Cuenta</a>
            @endif
          </li>

          <li class="{{$body_class == 'applicants' ? 'current' : ''}}">
          <a href="{{url('dashboard/cuestionarios')}}">Cuestionarios</a>
        </li>
         <!-- <li><a href="{{url('dashboard/datos')}}">Datos abiertos</a></li>
          <li><a href="{{url('dashboard/correos')}}">Correos</a></li>-->
        </ul>
    </div>
  </div>
</nav>







<!-- HEADER TEMPLATE ENDS -->




<!-- ERROR / SUCCESS MESSAGE -->
@if($status)
  <div class="{{$status->type}}"> 
  @if($status->type == "delete")
    <p>Se ha eliminado "{{$status->name}}"; Si tenía cuestionarios, 
    estos son visibles por cualquier adminsitrador.</p>  
  @elseif($status->type == "create")
    <p>Se ha creado "{{$status->name}}"</p>  
  @else
    <p>Hubo un error al crear "{{$status->name}}"</p> 
  @endif
  </div>
@endif
<!-- ERROR / SUCCESS MESSAGE -->

<div class="container">
  <div class="row">
      <h1 class="title">Usuarios</h1>
    <div class="row">
      <!-- add users-->
      <div class="col-sm-4">  
        <section class="box">

          <form name="add-admin" method="post" class="row" id="add-admin-form" action="dashboard/usuarios/crear">
            <h2>Crear usuario</h2>
            <div class="col-sm-12">
            <p><label>nombre</label><input id="the-new-name" type="text" name="name" value="{{old('name')}}"></p>
            <p><label>correo</label><input id="the-new-email" type="text" name="email" value="{{old('email')}}"></p>
            <p><label>contraseña</label><input id="the-new-pass" type="password" name="password"></p>
            <p>Tipo de usuario</p>
            <ul class="options">
              <li><label><input type="radio" name="level" value="2">funcionario</label></li>
              <li><label><input type="radio" name="level" value="3">administrador</label></li>
            </ul>
            <p><input type="submit" value="crear usuario"></p>
            </div>
          </form>

        </section>
      </div>
      <!--  admins list-->
      <div class="col-sm-8">  
        <section class="box">
          <h2>Administradores</h2>
          <h3>Total
              <strong>{{$admins->count()}}</strong>
            </h3>
           <ul class="list">
            <li class="row los_titles">
               <div class="col-sm-8">
                   <h4>Nombre</h4>
               </div>
               <div class="col-sm-4">
                    <h4>Correo</h4>
               </div>
            </li>

          @foreach($admins as $admin)
            <li class="row">
              <div class="col-sm-8">
               <a href="{{url('dashboard/usuario/' . $admin->id)}}">{{$admin->name}}</a>
              </div>
              <div class="col-sm-4">{{$admin->email}}</div>
            </li>
          @endforeach
          </ul>
        </section>
      </div>

      <!--  users list-->
      <div class="col-sm-8">  
        <section class="box">
          <h2>Funcionarios</h2>
          <h3>Total
              <strong>{{$users->count()}}</strong>
            </h3>
           <ul class="list">
            <li class="row los_titles">
               <div class="col-sm-8">
                   <h4>Nombre</h4>
               </div>
               <div class="col-sm-4">
                    <h4>Correo</h4>
               </div>
            </li>

          @foreach($users as $user)
            <li class="row">
              <div class="col-sm-8">
               <a href="{{url('dashboard/usuario/' . $user->id)}}">{{$user->name}}</a>
              </div>
              <div class="col-sm-4">{{$user->email}}</div>
            </li>
          @endforeach
          </ul>
        </section>
      </div>


    </div>
  </div>
</div>
<script>
/*
  // more crapy validation
  var form = document.getElementById('add-admin-form'),
      error = document.getElementById('error-message');

  form.onsubmit = function(e){
    e.preventDefault();
    var email = document.getElementById('the-new-email'),
        pass  = document.getElementById('the-new-pass');

    email.className = '';
    pass.className = '';
    error.innerHTML = "";

    if(! email.value){
      email.className = 'error'; 
      error.innerHTML = "el campo de correo está vacío :(";
      return;
    }
    if(pass.value.length < 8){
      pass.className = 'error'; 
      error.innerHTML = "mínimo 8 caracteres para la contraseña por favor!";
      return;
    } 
   
    this.submit();
  }
  */
</script>





<!-- MAIN DASHBOARD ENDS -->






<footer>

  
  <div class="links_bottom">
    <div class="container">
      <div class="row">
      <div class="col-sm-3">
        <p><span class="tu_evaluas">Tú Evalúas</span> ©2016</p>
      </div>
      <div class="col-sm-9">
        <ul>
          <li>Forjado Artesanalmente por <a href="http://gobiernofacil.com" class="gobiernofacil" title="Gobierno Fácil">Gobierno Fácil</a></li>
        </ul>
      </div>
    </div>
    </div>
  </div>
</footer>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45473222-7', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>
