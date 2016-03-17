@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<article class="data_hm">
			<div class="col-sm-8 col-sm-offset-2">
				<h1>Resultados de cuestionarios en <strong>Tú Evalúas</strong></h1>
				<section>
					@if ($surveys->count() > 0)
					<!-- FILTRAR RESULTADOS -->
				  <form id="fbp" name="filter-blueprints" method="get" action="{{url('resultados')}}">
				    <?php $category = $request->input('category') ? $categories->where("name", $request->input('category'))->first() : null; ?>
				    <pre>{{var_dump($categories->where("name", "Salud"))}}</pre>
				    {!! csrf_field() !!}
				    <p>Título: <input type="text" name="title" value="{{$request->input('title')}}"></p>

				    <p>
              <select name="category" id="survey-category">
                <option value="">Selecciona una categoría</option>
                @foreach($categories as $category)
                <option value="{{$category->name}}" {{$request->input('category') == $category->name ? 'selected' : ''}}>{{$category->name}}</option>
                @endforeach
              </select>
            </p>

            <!-- SUBCATEGORY -->
            <div>
              <p>Subcategoría</p>
              <ul id="sub-list">
              	
              </ul>
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
          </form>
						@foreach($surveys as $survey)
							<h2><a href="{{ url('resultados/'. $survey->id)}}">{{ $survey->title}}</h2>
							<a href="{{url('resultados/'. $survey->id) }}">
								<figure>
									<img src="{{url('img/programas/'.(empty($survey->banner) ? "default.jpg":$survey->banner))}}">
								</figure>
							</a>
							<p class="lead">
								<!-- aquí se agregará la descripción de cada encuesta-->
								<a href="{{ url('resultados/'.$survey->id)}}" class="btn"> Consulta los resultados</a>
							</p>
						@endforeach
					@else 
						<h2>Estamos trabajando para mejorar la descarga de los resultados de las encuestas. ¡Pronto estaremos de vuelta!</h2>
					@endif
				</section>
			</div>			
		</article>
	</div>
</div>

@endsection