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
						@foreach($blueprint->questions as $question)
						<li>
							<h3>{{ $question->question }}</h3>
							<ul class="row">
							<?php $total = $question->answers->count(); ?>
							@foreach($question->options as $option)
							  <?php
							    $subtotal = $question->answers->where("num_value", (float)$option->value)->count();
							    $share = number_format(($subtotal/$total)*100, 2);
							  ?>
							  <span class="clearfix">
								  <li class="col-sm-6">
								    {{$option->description}}: 
								    <strong>{{(int)$share ? $share : 0}}%</strong> <span class="total">({{$subtotal}})</span>
								  </li>
									<li class="col-sm-6">
										<span class="the_bar"> 
										  <span class="bar" style="width:{{$share}}%"></span>
										</span>
									</li>
							  </span>
							@endforeach
							</ul>
						</li>
						@endforeach
					</ol>
				</div>
			</div>			
		</article>
	</div>
</div>

@endsection