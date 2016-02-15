<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="es" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title;?></title>
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

<!-- ERROR / SUCCESS MESSAGE -->
<?php /*
<?php $m = $this->session->flashdata('sys_message'); if($m): ?>
  <div class="<?php echo $m["type"]; ?>"><?php echo $m["message"]; ?></div>
<?php endif; ?>
*/ ?>






<!-- HEADER TEMPLATE ENDS -->






<div class="container dashboard">
  <div class="row">
    <div class="col-md-12">
      <h1 class="title">Dashboard</h1>
    </div>
    <div class="col-sm-4 col-sm-offset-2 box">
      <h3><a href="{{url('dashboard/encuestas')}}"><strong>{{$surveys->count()}}</strong> 
        {{$surveys->count() == 1 ? 'Encuesta' :'Encuestas'}} &gt;</a></a>
      </h3>
      <p> <a href="{{url('dashboard/encuestas')}}">Crear Encuesta</a></p>
    </div>
    @if($user->level == 3)
    <div class="col-sm-4 col-sm-offset-1 box">
      <h3><a href="{{url('dashboard/usuarios')}}"><strong>{{$admins->count()}}</strong> 
        {{ $admins->count() == 1 ? 'Usuario' :'Usuarios'}} &gt;</a>
      </h3>
      <p> <a href="{{url('dashboard/usuarios')}}">Crear Usuario</a></p>
    </div>
    @endif
  </div>
  </div>
</div>






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
