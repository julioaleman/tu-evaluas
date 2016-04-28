@extends('layouts.master')

@section('content')

	<!--breadcrumb-->
	<div class="row">
      <div class="col-sm-8">
        <ol class="breadcrumb">
          <li><a href="#"><i class="icon icon-home"></i></a></li>
          <li><a href="https://www.gob.mx">Inicio</a></li>
          <li class="active">Tú Evalúas</li>
        </ol>
      </div>
	</div>
	<div class="row">
		<div class="col-md-12 bottom-buffer">
			<!--egb_div class="contenedor vertical-buffer"-->
				<image src="{{ url('img/logov0_.png') }}"></image>
			<!--egb_/div-->
		</div>
	</div>
	<div class="row bottom-buffer">
		<div class="col-md-8">
            <h2>Tu opinión sobre los programas públicos federales ayuda a mejorarlos.</h2>
    		<h4>Si recibes un correo con la invitación,<br>
    		¡<strong>participa</strong>, eres muy importante!</h4>
		</div>
	</div>
	
	<div class="bottom-buffer">
		<div class="row">
			@if($surveys->count() > 0)
			<div class="col-md-8">
				<h3>Programas Evaluados</h3>
				<hr class="red">
				<ul>
					@foreach($surveys as $survey)
					  <li> <a href="{{url('resultado/' . $survey->id)}}">{{$survey->title}} <strong>&gt;</strong></a> </li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
  
	<div class="bottom-buffer">
			<div class="row">
				<div class="col-md-8">
				<h2>¿Qué es <strong>Tú Evalúas</strong>?</h2>
					<hr class="red">
                    <p><strong>Tú Evalúas</strong> es una plataforma digital que <strong>tiene como objetivo evaluar el desempeño</strong> de los programas públicos 
                      federales mediante la participación ciudadana. A través de <strong>Tú Evalúas</strong> podrás calificar los procesos seguidos 
                      por cada programa y expresar tu 
                      satisfacción con los productos y servicios que ofrecen.</p>
                    <p><strong>Tú Evalúas</strong> facilitará la colaboración entre el gobierno y la ciudadanía partiendo de una base 
                      tecnológica para:</p>
                    <ol>
                      <li>Conocer la opinión ciudadana sobre la operación de los programas.</li>
                      <li>Mejorar la evaluación de los programas con base en las necesidades expresadas directamente por la ciudadanía.</li>
                      <li>Generar espacios de aprendizaje que conduzcan a mejores políticas públicas.                 </li>
                    </ol>
                    <p>La meta es que <strong>Tú Evalúas</strong> reúna toda la información referente a la satisfacción de la ciudadanía 
                      con respecto a los programas públicos federales para que quien lo desee (ciudadanos, 
                      asociaciones, gobierno o la comunidad en conjunto) pueda dar seguimiento al pulso ciudadano.
                    </p>
                    <hr>
				</div>
			</div>
	</div>				
</div>
@endsection