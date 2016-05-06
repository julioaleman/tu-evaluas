ç@extends('layouts.master')

@section('content')
<hr>
<div class="container">
	<div class="row">
		<article class="data_hm">
			<div class="col-sm-8 col-sm-offset-2">
				<h1>Resultados de Cuestionario: <strong>{{ $blueprint->title }}</strong></h1>
		<hr class="red">
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
				    	
				    	<!-- RESPUESTA MÚLTIPLE - MÚLTIPLE -->
				    	@elseif($question->type == "multiple-multiple")
				    	  <h5>{{$question->question}}</h5>
				    	  <?php 
				    	    $options = $question->options;
				    	    $total   = $question->answers->count();
				    	  ?>
				    	  @foreach($options as $option)
				    	    <?php 
				    	      $opt    = $option->description;
				    	      $num    = $question->answers()->whereRaw("FIND_IN_SET({$option->value},text_value)")->count();
				    	      $title  = $option->description;
				    	      $amount = round(($num / $total) * 100, 2);
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
				    	<!-- RESPUESTA ESTADO -->
				    	@elseif(in_array($question->type, ["location-a", "location-b", "location-c"]))
				    	 <h5>{{$question->question}}</h5>
				    	  <?php 
				    	    $options = $question->answers()->select(DB::raw('count(*) as total, text_value'))->groupBy("text_value")->get();
				    	    $total   = $question->answers->count();
				    	  ?>
				    	  @foreach($options as $option)
				    	    <?php 
				    	      $opt    = $option->text_value;
				    	      $num    = $option->total;
				    	      $title  = $test($question->type, $option);
				    	      $amount = round(($num / $total) * 100, 2);
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
				
				    @endforeach
					</ul>
				</div>
			</div>			
		</article>
	</div>
</div>

@endsection