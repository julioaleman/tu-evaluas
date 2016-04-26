@extends('layouts.master')

@section('content')

<div class="container.vertical-buffer">
  <header class="row">
    <div class="col-sm-8 col-sm-offset-2">
	    <hr>
      	<div class="contenedor image.vertical-buffer" align="center">
        	<img src="{{ url('img/logov0.png') }}" width="750"></image>
    	</div>
<h2 align="center" class="intro">Tu opinión sobre los programas públicos federales ayuda a mejorarlos.<br><br></h2>
      <h4 align="center">Si recibes un correo con la invitación,<br>
        ¡<strong>participa</strong>, eres muy importante!<br><br><br></h4>
    </div>
  </header>
  <section class="programs">
	  <div class="container">
	    <div class="row">
	    @if($surveys->count() > 0)
	    <hr>
	    	<div class="col-sm-8 col-sm-offset-2">
				<h3>Programas Evaluados</h3>
				<hr class="red">
	    	</div>
	    	<div class="col-sm-8 col-sm-offset-2">
				<ul>
					@foreach($surveys as $survey)
					  <li> <a href="{{url('resultado/' . $survey->id)}}">{{$survey->title}} <strong>&gt;</strong></a> </li>
					@endforeach
				</ul>
	    	</div>
    	@endif
        <div class="col-sm-8 col-sm-offset-2">
        <h3 class="intro">¿Qué es <strong>Tú Evalúas</strong>?</h3>
        <hr class="red">
        <p><strong>Tú Evalúas</strong> es una plataforma digital que <strong>tiene como objetivo evaluar el desempeño</strong> de los programas públicos 
          federales mediante la participación ciudadana. A través de <strong>Tú Evalúas</strong> podrás calificar los procesos seguidos 
          por cada programa y expresar tu 
          satisfacción con los productos y servicios que ofrecen.</p>
        <p><strong>Tú Evalúas</strong> facilitará la colaboración entre el gobierno y la ciudadanía partiendo de una base 
          tecnológica para:</p>
        <ol>
          <li>Conocer la opinión ciudadana sobre la operación de los programas                      </li>
          <li>Mejorar la evaluación de los programas con base en las necesidades expresadas directamente por la ciudadanía</li>
          <li>Generar espacios de aprendizaje que conduzcan a mejores políticas públicas.                 </li>
        </ol>
        <p>La meta es que <strong>Tú Evalúas</strong> reúna toda la información referente a la satisfacción de la ciudadanía 
          con respecto a los programas públicos federales para que quien lo desee (ciudadanos, 
          asociaciones, gobierno o la comunidad en conjunto) pueda dar seguimiento al pulso ciudadano.
        </p>
        <br>
        <br>
    </div>
    	</div>
    	</div>
  </section>
</div>
@endsection