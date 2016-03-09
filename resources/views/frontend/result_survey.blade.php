@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<article class="data_hm">
			<div class="col-sm-8 col-sm-offset-2">
				<h1>Resultados de Cuestionario: <strong>{{ $blueprint->title }}</strong></h1>
				<?php /*if($file): ?><section class="row">
					
					
					<a class="btn col-sm-5" href="<?php echo $file; ?>">Descargar datos en CSV</a>
				  <?php endif;
				</section> */ ?>
				<div class="answers">
					<h2>Respuestas</h2>
					<!-- comienza lista de preguntas-->
					<ol>
						@foreach($questions as $question)
						<li {{ empty($question->options) ? "class='hide'" :'' }} >
							<h3>{{ $question->question }}</h3>
							@if(empty($question->options))
							<!--	// si no hay opciones-->
								@foreach($question->answers as $respuesta)
									<p>{{$respuesta->num_value}}</p>
								@endforeach
							@else
							<ul class="row">
								@foreach($question->options as $respuesta)
								<span class="clearfix">
									<li class="col-sm-6">
									<?php $le_total = 0; /// buscamos el total de respuestas de la pregunta?>
										@foreach ($array_answer as $los_totales)
											@if ($los_totales['id'] == $question->id)
												<?php $le_total = $los_totales['total_num'];?>		
											@endif
										?>
										@endforeach
										@if ($le_total > 0)
										<!--///calcula porcentaje de respuestas… sad thing-->
											<?php $amount =  ($respuesta->answer_num / $le_total) * 100;
												  $amount = round($amount, 2);?>
										@else 
											<?php $amount = 0;?>
										@endif
										
										{{  $respuesta->description }}: <strong>{{ $amount }}%</strong> 
										<span class="total">( {{$respuesta->answer_num}} )</span>
									
									</li>
									<li class="col-sm-6">
										<span class="the_bar"> 
										<span class="bar" style="width:<?php echo $amount;?>%"></span>
										</span>
									</li>
								</span>
								@endforeach
										
								</ul>

							@endif
						</li>
						@endforeach
					</ol>
				</div>
			</div>			
		</article>
	</div>
</div>

@endsection