@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<article class="data_hm">
			<div class="col-sm-8 col-sm-offset-2">
				<h1>Resultados de cuestionarios en <strong>Tú Evalúas</strong></h1>
				<section>
					@if ($surveys->count() > 0)
						@foreach($surveys as $survey)
						 @if ($survey->is_public == 1)
							<h2><a href="{{ url('resultados/'. $survey->id)}}">{{ $survey->title}}</h2>
							<?php 
								switch($survey->id){
										case 1:
											$figure = "prospera.jpg";
											break;
										case 2: 
											$figure = "inadem.jpg";
											break;
										default:
											$figure = "default.jpg";
								}?>
							
							<a href="{{url('resultados/'. $survey->id) }}">
								<figure>
									<img src="{{url('img/programas/'.$figure)}}">
								</figure>
							</a>
							<p class="lead">
								<!-- aquí se agregará la descripción de cada encuesta-->
								<a href="{{ url('resultados/'.$survey->id)}}" class="btn"> Consulta los resultados</a>
							</p>
							@endif
						@endforeach
					@else 
						<h2>Aún no hay encuestas para descargar</h2>
					@endif
				</section>
			</div>			
		</article>
	</div>
</div>

@endsection