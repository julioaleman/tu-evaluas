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
    <p>Se ha eliminado "{{$status->name}}"</p>  
  @elseif($status->type == "create")
    <p>Se ha creado "{{$status->name}}"</p>  
  @else
    <p>Se actualizó "{{$status->name}}"</p> 
  @endif
  </div>
@endif
<!-- ERROR / SUCCESS MESSAGE -->


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 class="title">Encuestas</h1>
      <div class="row">
        <!-- add survey-->
        <div class="col-sm-4">
          <section class="box">
            <h2>Crear encuesta</h2>

            <!-- SEARCH SURVEY -->
            <form id="search-survey" name="search-survey" method="post" class="row" action="{{url('dashboard/encuestas/buscar/json')}}">
            {!! csrf_field() !!}
            <div class="col-sm-12">
              <p><label>Buscar encuesta: </label> 
                <input type="text" name="query" class="typeahead">
              </p>
            </div>
          </form>
          <!-- SEARCH SURVEY ENDS -->

          <!-- SEARCH USERS -->
          @if($user->level == 3)
          <form id="search-user" name="search-user" method="post" class="row" action="{{url('dashboard/usuarios/buscar/json')}}">
            {!! csrf_field() !!}
            <div class="col-sm-12">
              <p><label>Buscar usuario (email): </label> 
                <input type="text" name="query" class="typeahead">
              </p>
            </div>
          </form>
          @endif
          <!-- SEARCH USERS ENDS -->


          <form name="add-survey" method="post" class="row" action="{{url('dashboard/encuestas/crear')}}">
            {!! csrf_field() !!}
            <div class="col-sm-12">
              <p><label>Título: </label> 
                <input type="text" name="title">
              </p>
            </div>
            <div class="col-sm-12">
             <p><input type="submit" value="crear encuesta"></p>
            </div>
          </form>
          </section>
        </div>
        
        <!-- survey list-->
        <div class="col-sm-8">
          <section class="box">
            <h2>Encuestas</h2>
            <h3>Total de Encuestas
              <strong>{{$surveys->count()}}</strong>
            </h3>
            
            <ul class="list">
              <li class="row los_titles">
                 <div class="col-sm-10">
                   <h4>Nombre</h4>
                 </div>
                 <div class="col-sm-2">
                    <h4>Acciones</h4>
                 </div>
              </li>
            <?php foreach($surveys as $survey): ?>
              <li class="row">
                <div class="col-sm-10">
                <a href="{{url('dashboard/encuestas/' . $survey->id)}}">{{$survey->title}}</a>
                </div>
                 <div class="col-sm-2">
                  <a data-title="{{$survey->title}}" href="{{url('dashboard/encuestas/eliminar/' . $survey->id)}}" class="danger">Eliminar</a>
                 </div>
              </li>
            <?php endforeach; ?>
            </ul>
          </section>
        </div>
        
      </div><!--- ends row-->
    </div>
  </div>
</div>

<script src="/js/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/js/bower_components/typeahead.js/dist/typeahead.jquery.min.js"></script>
<script src="/js/bower_components/typeahead.js/dist/bloodhound.min.js"></script>
<script src="/js/bower_components/sweetalert/dist/sweetalert.min.js"></script>
<script>
  /*
   * ENABLE THE USERS AND SURVEY SEARCH
   *
   */
  $(document).ready(function(){

    // DELETE SURVEY WARNING
    //
    //
    //
    $("ul.list").on("click", ".danger", function(e){
      e.preventDefault();
      var url   = $(this).attr("href"),
          title = $(this).attr("data-title");
      deleteSurvey(url, title);
    });

    function deleteSurvey(url, title){
      swal({
        title: "Eliminar encuesta", 
        text: "Vas a eliminar \"" + title + "\" del sistema. Esto no se puede deshacer!", 
        type: "warning",
        confirmButtonText : "Eliminar",
        //confirmButtonColor: "#ec6c62"
        showCancelButton: true,
        cancelButtonText : "Mejor no",
      }, function(){
        window.location.href = url;
      });
    }

    // THE SURVEY SEARCH
    //
    //
    //

    // [1] define the search engine
    var surveys = new Bloodhound({
      // [1.1] default setup
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
        // [1.2] set the search URL
        url: $("#search-survey").attr("action"),
        // [1.3] write the query URL
        prepare : function(a, b){
          var base = $("#search-survey").attr("action"),
              full = base + "?query=" + a;

          b.url = full;
          return b;
        }

      }
      
    });

    // [2] enable the search field
    $('#search-survey .typeahead').typeahead(null, {
      name: 'query',
      display: 'title',
      source: surveys
    });


    // THE USERS SEARCH
    //
    //
    //
    var users = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      // prefetch: $("#search-survey").attr("action"),
      
      remote: {
        url: $("#search-user").attr("action"),
        prepare : function(a, b){
          var base = $("#search-user").attr("action"),
              full = base + "?query=" + a;

          b.url = full;
          return b;
        }

      }
      
    });

    $('#search-user .typeahead').typeahead(null, {
      name: 'query',
      display: 'email',
      source: users
    });

    $('.typeahead').bind('typeahead:select', function(ev, suggestion){
      console.log(suggestion);
      if(suggestion.email){
        window.location.href = "{{url('dashboard/usuarios')}}/" + suggestion.id;
      }
      else{
        window.location.href = "{{url('dashboard/encuestas')}}/" + suggestion.id;
      }
    });
  });
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
