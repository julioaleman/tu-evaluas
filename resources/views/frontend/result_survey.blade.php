@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-sm-8">
    <ol class="breadcrumb">
      <li><a href="https://www.gob.mx"><i class="icon icon-home"></i></a></li>
      <li><a href="{{ url('') }}">Tú Evalúas</a></li>
      <li class="active">Resultados</li>
    </ol>
  </div>
</div>
				
<article class="data_hm">
	<div class="row">
		<div class="col-md-8">
			<h2>{{ $blueprint->title }}</h2>
			<hr class="red">
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-8">
				<div class="answers">
					<h4>Respuestas</h4>
					<!-- comienza lista de preguntas-->
					<ol>
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
				    	       $amount = $total ? round(($num / $total) * 100, 2) : 0;
				    	     ?>
				    	    <p>
				    	      {{$title}} <strong>{{$amount}}%</strong> <span class="total">({{$num}})</span>
				    	    </p>
				    	   	<p>
				    	   	  <span class="the_bar"> 
										  <span class="bar" style="
										  width:{{$amount}}%;
										  display: inline-block;
										  background: #DDDDDD;
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
				    	      $amount = $total ? round(($num / $total) * 100, 2) : 0;
				    	    ?>
				    	     <p>
				    	      {{$title}} <strong>{{$amount}}%</strong> <span class="total">({{$num}})</span>
				    	    </p>
				    	   	<p>
				    	   	  <span class="the_bar"> 
										  <span class="bar" style="
										  width:{{$amount}}%;
										  display: inline-block;
										  background: #DDDDDD;
										  height: 1em;
										  "></span>
										</span>
									  </p>
				    	  @endforeach
				    	<!-- RESPUESTA UBICACIÓN -->
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
				    	      $amount = $total ? round(($num / $total) * 100, 2) : 0;
				    	    ?>
				    	     <p>
				    	      {{$title}} <strong>{{$amount}}%</strong> <span class="total">({{$num}})</span>
				    	    </p>
				    	    <p>
				    	   	  <span class="the_bar"> 
										  <span class="bar" style="
										  width:{{$amount}}%;
										  display: inline-block;
										  background: #DDDDDD;
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
					<hr>
				    @endforeach
					</ol>
				</div>
			</div>	
	</div>		
	<div class="row">
		<div class="col-md-8">
			<a href="{{ $blueprint->ptp }}" class="btn btn-primary">Conoce el desempeño del programa presupuestario</a>
		</div>
	</div>
</article>
@endsection