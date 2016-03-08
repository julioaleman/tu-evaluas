@extends('layouts.master_admin')

@section('content')

<!-- ERROR / SUCCESS MESSAGE -->
@if(count($errors) > 0)
  <div class="alert">
    <ul>
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
  </div>
@endif

@if($status)
  <div class="{{$status['type']}}"> 
  @if($status['type'] == "delete")
    <p>Se ha eliminado "{{$status['name']}}"</p>  
  @elseif($status['type'] == "create")
    <p>Se ha creado "{{$status['name']}}"</p>  
  @else
    <p>Se actualizó "{{$status['name']}}"</p> 
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
          <!-- CREATE SURVEY -->
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
          <!-- CREATE SURVEY -->
          </section>


          <section class="box">
            <h2>Buscar</h2>
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
          </section>


          <section class="box">
            <h2>Crear encuesta desde un archivo</h2>
          <!-- CREATE SURVEY FROM CSV -->
          <form name="add-survey-from-csv" method="post" enctype="multipart/form-data" class="row" action="{{url('dashboard/encuestas/crear/csv')}}">
            {!! csrf_field() !!}
            
            @if(count($errors))
            <!-- La validación -->
            <p>Debes escribir el título del cuestionario y agregar un archivo CSV válido</p>
            @endif

            <div class="col-sm-12">
              <p>
                <label>Título: </label> 
                <input type="text" name="title">
              </p>
              <p>
                <label>Archivo CSV</label>
                <input type="file" name="the-csv">
              </p>
              <p><a href="{{url('el-csv-para-preguntas')}}" target="_blank">Cómo debe ser el CSV</a></p>
            </div>
            <div class="col-sm-12">
             <p><input type="submit" value="crear encuesta"></p>
            </div>
          </form>
          <!-- CREATE SURVEY FROM CSV -->
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
        window.location.href = "{{url('dashboard/usuario')}}/" + suggestion.id;
      }
      else{
        window.location.href = "{{url('dashboard/encuestas')}}/" + suggestion.id;
      }
    });
  });
</script>

@endsection