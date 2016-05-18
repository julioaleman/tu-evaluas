@extends('layouts.master_admin')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
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

@if(!empty($status))
  <div class="{{$status['type']}}"> 
  @if($status['type'] == "delete")
    <p>Se ha eliminado "{{$status['name']}}"</p>  
  @elseif($status['type'] == "create")
    <p>Se ha creado "{{$status['name']}}"</p>
  @elseif($status['type'] == "authorize")
    <p>Se ha solicitado la autorización para publicar: "{{$status['name']}}"</p>
  @elseif($status['type'] == "cancel")
    <p>Se canceló la petición de autorización.</p> 
  @elseif($status['type'] == "file create")
    <p>El archivo para : "{{$status['name']}}" se está generando. Espera un momento.</p>
  @elseif($status['type'] == "authorize create")
    <p>La encuesta: "{{$status['name']}}" se ha publicado</p>
  @elseif($status['type'] == "hide create")
    <p>La encuesta: "{{$status['name']}}" se ha ocultado</p>
  @elseif($status['type'] == "show create")
    <p>La encuesta: "{{$status['name']}}" es visible</p>
  @elseif($status['type'] == "finish create")
    <p>La encuesta: "{{$status['name']}}" ha terminado</p>
   @elseif($status['type'] == "csv create")
    <p>Se ha generado el CSV para "{{$status['name']}}"</p>
  @else
    <p>Se actualizó "{{$status['name']}}"</p> 
  @endif
  </div>
@endif
<!-- ERROR / SUCCESS MESSAGE -->



    	<h1 class="title">Editar Encuesta</h1>
    </div>
  </div>

  


  <!-- [[   T H E   A P P   ]] -->
  
  <div class="row">
    <!-- [ THE BLUEPRINT ] -->
    <div class="col-sm-4">
      <section id="survey-app-title" class="box">
		<a href="{{url('dashboard/encuesta/test/' . $blueprint->id)}}" class="btn_test preview">Previsualizar encuesta</a>
        <h2>Datos</h2>
        <form id="ubp" name="update-blueprint" action="{{url('dashboard/encuesta/' . $blueprint->id)}}" enctype="multipart/form-data" method="post">
          {!! csrf_field() !!}
          <!-- THE TITLE -->
          <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
              <p><strong>Título</strong></p>
              <p id="js-error-title" class="error"></p>
              <p><input type="text" name="survey-title" value="{{$blueprint->title}}" required></p>
            </div>
          </div>

           <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
              <p><strong>Descripción</strong></p>
              <p id="js-error-description" class="error"></p>
              <p><textarea name="survey-description">{{$blueprint->description}}</textarea></p>
            </div>
          </div>

          <div class="divider"></div>
          <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
              <p><strong>Ramo</strong></p>
              <p id="js-error-branch" class="error"></p>
              <p>
                <select name="survey-branch" id="survey-branch" required>
                  <option value="">Selecciona un ramo</option>
                </select>
              </p>
            </div>

            <div class="col-sm-10 col-sm-offset-1">
              <p>Programa presupuestario</p>
              <p id="js-error-program" class="error"></p>
              <p>
                <select name="survey-program" id="survey-program" required>
                  <option value="">Selecciona un programa presupuestario</option>
                </select>
              </p>
            </div>
          </div>

          <input type="hidden" id="survey-ptp" name="survey-ptp" value="{{$blueprint->ptp}}">

		  <div class="divider"></div>
          <!-- CATEGORY / DEPENDENCY? -->
          <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
              <p><strong>Categoría</strong></p>
              <p id="js-error-category" class="error"></p>
              <p>
                <select name="survey-category" id="survey-category" required>
                  <option value="">Selecciona una categoría</option>
                </select>
              </p>
            </div>

             <!-- SUBCATEGORY -->
            <div class="col-sm-10 col-sm-offset-1">
              <p>Subcategoría</p>
              <p id="js-error-subcategory" class="error"></p>
              <p class="rule">Puedes seleccionar un máximo de 3 subcategorías</p>
              <ul id="sub-list"></ul>
              <!-- survey-tags-->
            </div>

             <!-- TAGS -->
            <div class="col-sm-10 col-sm-offset-1">
              <p>Etiquetas</p>
              <p id="js-error-tags" class="error"></p>
              <p class="rule">Puedes seleccionar un máximo de 5 etiquetas</p>
              <ul id="tag-list"></ul>
              <!-- survey-tags-->
            </div>
          </div>
          
		  <div class="divider"></div>
          <!-- BANNER -->
          <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
              <p><strong>Selecciona la portada</strong></p>
              <img id="target" src="{{empty($blueprint->banner) ? "": url("img/programas/" . $blueprint->banner) }}" />
              <p><input type="file" name="survey-banner" id="survey-banner"></p>
            </div>
          </div>

       <div class="divider"></div>
          <!-- SUBMIT -->
          <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
              <p><input type="submit" value="Guardar Cambios"></p>
            </div>
          </div>
        </form>
        <div class="divider"></div>

        <!-- BLUEPRINT CONTROL -->
        <h2>Controles</h2>
        @if($blueprint->type == "regular" || $blueprint->type == "generated")
          <!-- PUBLICAR  / TERMINAR ENCUESTA   -->
          <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
              <p>
              @if($user->level ==3)
                @if($blueprint->is_public)
                  <a data-title="Deseas terminar la encuesta? Para reiniciarla es necesario pedir autorización. También es posible ocultar la encuesta con el botón de 'ocultar encuesta'." id="finish-survey-btn" href="{{url('dashboard/encuestas/cerrar/confirmar/' . $blueprint->id)}}/1" class="create-survey-btn">Terminar encuesta</a>
                @elseif($blueprint->is_closed)
                  <a href="{{url('dashboard/encuestas/autorizar/confirmar/' . $blueprint->id)}}/1" class="create-survey-btn">Iniciar encuesta nuevamente</a>
                @else
                  <a href="{{url('dashboard/encuestas/autorizar/confirmar/' . $blueprint->id)}}/1" class="create-survey-btn">Iniciar encuesta</a>
                @endif
             
              @else
                @if($blueprint->is_public)
                  <a data-title="Deseas terminar la encuesta? Para reiniciarla es necesario pedir autorización. También es posible ocultar la encuesta con el botón de 'ocultar encuesta'." id="finish-survey-btn" href="{{url('dashboard/encuestas/cerrar/confirmar/' . $blueprint->id)}}/1" class="create-survey-btn">Terminar encuesta</a>
                @elseif($blueprint->pending)
                  <a href="{{url('dashboard/encuestas/cancelar/' . $blueprint->id)}}" class="btn_test preview">cancelar autorización!</a>
                  <br>(La encuesta está en proceso de ser autorizada)  
                @elseif($blueprint->is_closed)
                  <a href="{{url('dashboard/encuestas/autorizar/' . $blueprint->id)}}" class="create-survey-btn">Iniciar encuesta nuevamente</a>
                @else
                  <a href="{{url('dashboard/encuestas/autorizar/' . $blueprint->id)}}" class="btn_test preview">Publica la encuesta</a>
                @endif
              @endif
              </p>
            </div>
          </div>
          <div class="divider"></div>
        @endif

        @if($user->level ==3)
        <!-- GENERAR ARCHIVOS PARA DESCARGA : ADMIN  -->
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <p>
            @if($blueprint->csv_file == '' && ($blueprint->is_closed || $blueprint->is_public))
              <a href="{{url('dashboard/encuestas/crear/csv/' . $blueprint->id)}}" class="create-survey-btn">Crear archivos para descargar</a>
            @elseif($blueprint->type == "results")
              <a download href="{{url('csv/' . $blueprint->csv_file)}}">descargar resultados</a>
            @elseif(!empty($blueprint->csv_file))
              <a download href="{{url('csv/' . $blueprint->csv_file . '.csv')}}">descargar CSV</a> <br>
              <a download href="{{url('csv/' . $blueprint->csv_file . '.xlsx')}}">descargar XLS</a> <br>
              <a href="{{url('dashboard/encuestas/crear/csv/' . $blueprint->id)}}" class="create-survey-btn">Generar archivos nuevamente</a>
            @else
              Para descargar o generar archivos, es necesario que la encuesta esté en curso o haya terminado.
            @endif
            </p>
          </div>
        </div>
        <div class="divider"></div>

        @endif


        <!-- OCULTAR / MOSTRAR LA ENCUESTA : ADMIN  -->
        @if($blueprint->is_closed || $blueprint->is_public)
         <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
          <p>
            @if($blueprint->is_visible)
              <a href="{{url('dashboard/encuestas/ocultar/confirmar/' . $blueprint->id)}}" class="create-survey-btn">Ocultar encuesta</a>
            @else
              <a href="{{url('dashboard/encuestas/mostrar/confirmar/' . $blueprint->id)}}" class="create-survey-btn">Mostrar encuesta</a>
            @endif
            </p>
          </div>
        </div>
        <div class="divider"></div>
        @endif


       



      </section>
    </div>
    <!-- { THE BLUEPRINT ENDS } -->


    <form name="survey-app">
    <div class="col-sm-8">  
    <!-- [ MESSAGE FOR GENERATED QUESTIONS ] -->
    @if($blueprint->type == "results")
    <section id="the-survey-only-results" class="box">
    <h2>Encuesta de solo resultados</h2>
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        Esta encuesta no puede tener preguntas, es solo un archivo para descargar
      </div>
    </div>
    </section>
    @endif

    <!-- [ THE CONTENT CREATOR ] -->
    <section id="survey-app-questions" class="box" <?php echo $blueprint->type == 'results' ? "style='display: none'" : ''; ?>>
      <h2>Agregar preguntas</h2>
    <!-- [ ADD CONTENT BUTTONS ] -->
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
	  	<p id="survey-add-buttons">
	  	  <a href="#" class="add-question">Agrega pregunta</a> | 
	  	  <a href="#" class="add-text">Agrega texto(HTML)</a>
	  	</p>
      
      <!-- [ NEW QUESTION FORM ] -->
      <div id="survey-add-question" class="new_question" style="display:none">
        <!-- [1] agrega el título -->
        <p>
          <label><strong>Pregunta:</strong></label>
          <input name="question" type="text">
        </p>
        <!-- [1] --> 
        <!-- [2] define el tipo de pregunta -->
        <p>
          <label>la respuesta es:</label>
          <label><input type="radio" name="type" value="text">abierta</label>
          <label><input type="radio" name="type" value="number">numérica</label>
          <label><input type="radio" name="type" value="multiple">opción múltiple (una)</label>
          <label><input type="radio" name="type" value="multiple-multiple">opción múltiple (varias)</label>
          <label><input type="radio" name="type" value="location-a">ubicación (estado)</label>
          <label><input type="radio" name="type" value="location-b">ubicación (estado, municipio)</label>
          <label><input type="radio" name="type" value="location-c">ubicación (estado, municipio, localidad)</label>
          <label><input type="radio" name="type" value="personal">Información personal</label>
        </p>
        <!-- [2] -->
        
        <!-- [3] muestra el aviso sobre la información personal -->
        <div id="personal-warning" style="display:none">
          <h4>Información personal</h4>
          <p>La información capturada en este campo, no estará disponible en línea.</p>
        </div>

        <!-- [4] agrega las respuestas para opción múltiple -->
        <div id="survey-add-options" style="display:none">
          <h4>Opciones de respuesta:</h4>
          <p>Presiona [ ENTER ] para agregar otra respuesta</p>
          <ul>
          </ul>
          <p>
            <label>
              <input type="checkbox" id="keep-options" value="1">
              conservar respuestas
            </label>
          </p>
        </div>
        <!-- [4] -->
        
        <!-- [3] define a la sección a la que pertenece la pregunta -->
        
        <div class="survey-section-selector-container"><!-- weird hack -->
        <p class="survey-section-selector" style="display:none">
          <label><strong>Sección a la que pertenece:</strong>
          <select name="section_id">
            <option value="1" selected>sección 1</option>
            <option value="0">nueva sección</option>
          </select></label>
        </p>
        </div><!-- weird hack ends -->
        <!-- [3] -->
        
        <!-- [5] salva la pregunta -->
        <p><a id="survey-add-question-btn" href="#" class="btn_add">agregar</a></p>
        <!-- [5] -->
      </div>
      <!-- { NEW QUESTION FORM ENDS } -->


      <!-- [ NEW CONTENT FORM ] -->
      <div id="survey-add-content" style="display:none">
        <p><label>HTML:</label></p>
        <p><textarea name="html"></textarea></p>
        <div class="survey-section-selector-container"><!-- weird hack -->
        </div><!-- weird hack ends -->
        <p><a id="survey-add-content-btn" href="#" class="btn_add">Agregar contenido</a></p>
      </div>
      <!-- { NEW CONTENT FORM ENDS } -->
          </div>
        </div>
    </section>
    <!-- { THE CONTENT CREATOR ENDS } -->

    <!-- [ THE SURVEY ] -->
<section id="the-survey" class="box" <?php echo $blueprint->type == 'results' ? "style='display: none'" : ''; ?>>
  <h2>Preguntas agregadas</h2>
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1">
      
      <!-- [ THE SECTION NAVIGATION ] -->
      <div id="survey-app-navigation" style="display:none">
        <ul id="survey-navigation-menu"></ul>
        

        <!-- [ THE RULES NAVIGATION ] -->
        <div id="survey-navigation-rules-container" style="display:none">
          <h5>Reglas de navegación de la sección</h5>
          <p class="instructions">Selecciona una pregunta y su respuesta para determinar que usuarios verán esta sección</p>
          <p id="survey-add-navigation-rule">
            <select class="select-question">
              <option value="">Selecciona una pregunta</option>
            </select>

            <select class="select-answer" style="display:none">
              <option value="">Selecciona una respuesta</option>
            </select>

            <a href="#" class="add-rule-btn btn_add">Agregar Regla</a>
          </p>
          <ul id="survey-navigation-rules" start="1"></ul>
        </div>


      </div>
      
      <ol id="survey-question-list" start="1"></ol> 
    </div>
  </div>
</section>
    <!-- { THE SURVEY ENDS } -->
    
    </div>
    </div>
  </form>
  <!--    T H E   A P P   E N D S    -->
  
  </div>
</div>

    <!-- THE INITIAL DATA -->

    <script>

      var BASE_PATH  = "{{url('/')}}",
      SurveySettings = {
        blueprint : <?= json_encode($blueprint); ?>,
        questions : <?= json_encode($questions); ?>,
        options   : <?= json_encode($options); ?>,
        rules     : <?= json_encode($rules); ?>
      };

      // survey-app-questions
      // the-survey

    </script>
    <!-- DEVELOPMENT SOURCE -->
    <script data-main="/js/main.admin" src="/js/bower_components/requirejs/require.js"></script>

@endsection