@extends('layouts.master')

@section('content')
<hr>
<div class="container">
	<div class="row">
		<article class="data_hm">
			<div class="col-sm-8 col-sm-offset-2">
				<h1>Resultados de Cuestionario: <strong>{{ $blueprint->title }}</strong></h1>
		<hr class="red">
				<?php /*if($file): ?><section class="row">
					
					
					<a class="btn col-sm-5" href="<?php echo $file; ?>">Descargar datos en CSV</a>
				  <?php endif;
				</section> */ ?>
				<div class="answers">
					<h2>Respuestas</h2>
						
					<!-- comienza lista de preguntas-->
					<ul>
				    @foreach($blueprint->questions as $question)
				    <li>
				      <!-- DESCRIPCIONES -->
				    	@if($question->is_description)
				    	  <p>{{$question->question}}</p>
				    	
				    	 <!-- INFORMACIÓN PERSONAL -->
				    	@elseif($question->type == "personal")
				    	  <h5>{{$question->question}}</h5>
				    	  <p>[ es un dato personal ]</p>
				    	
				    	 <!-- RESPUESTA MÚLTIPLE (una) -->
				    	@elseif($question->type == "multiple")
				    	  <h5>{{$question->question}}</h5>
				    	  <?php 
				    	    $options = $question->options;
				    	    $total   = $question->answers->count();
				    	  ?>
				    	  @foreach($options as $option)
				    	     <?php 
				    	       $opt    = $option->description;
				    	       $num    = $question->answers->where("text_value", $opt)->count(); 
				    	       $title  = $option->description;
				    	       $amount =  round(($num / $total) * 100, 2);
				    	     ?>
				    	    <p>
				    	      {{$title}} <strong>{{$amount}}%</strong> <span class="total">({{$num}})</span>
				    	    </p>
				    	   	<p>
				    	   	  <span class="the_bar"> 
										  <span class="bar" style="
										  width:{{$amount}}%;
										  display: inline-block;
										  background: black;
										  height: 1em;
										  "></span>
										</span>
									  </p>
				    	  @endforeach
				    	
				    	 <!-- RESPUESTA NUMÉRICA -->
				    	@elseif($question->type == "number") 
				    	<h5>{{$question->question}}</h5>
				    	  resultados : {{$question->answers->count()}}<br>
				    	  min : {{$question->answers->min('num_value')}} <br>
				    	  max : {{$question->answers->max('num_value')}} <br>
				    	  promedio : {{$question->answers->avg('num_value')}} 
				    	
				    	 <!-- PREGUNTA ABIERTA -->
				    	@elseif($question->type == "text")
				    	  <h5>{{$question->question}}</h5>
				    	  <p>[ las preguntas abiertas estarán disponibles al terminar la encuesta en formato abierto ]</p>
				    	@endif
				    </li>
				    <?php 
				    /*
						<li {!! $question->options->count() == 0 ? "class='hide'" :'' !!}>
							<h3>{{ $question->question }}</h3>
							@if($question->options->count() > 0)
							<ul class="row">
								<?php /// total de respuestas para pregunta 
									$le_total = $question->answers->count();?>
								@foreach($question->options as $option)
								<span class="clearfix">
									<li class="col-sm-6">
									{{ $option->description }}
									<?php  // intento para calcurar respuestas por opcion 
										$option_answers = 0;?>
									@if ($option->value == 	$question->answers[0]->num_value)
										<?php // suma si coincide opción y respuesta 
											$option_answers++;?>
									@endif
									<?php  /// calcula porcenta
										   $amount =  ($option_answers / $le_total) * 100;
										   $amount = round($amount, 2);?>
									 <strong>{{$amount}}%</strong> <span class="total">({{$option_answers}})</span>
									</li>
									<li class="col-sm-6">
										<span class="the_bar"> 
										  <span class="bar" style="width:{{$amount}}%"></span>
										</span>
									</li>
								</span>
								@endforeach
							</ul>
							@else
							<!--pronto-->
							@endif			
						</li>
					*/ ?>
				    @endforeach
					</ul>
				</div>
			</div>			
		</article>
	</div>
</div>

@endsection