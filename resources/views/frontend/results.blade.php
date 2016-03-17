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
					<h2>Filtrar resultados</h2>
				  <form id="fbp" name="filter-blueprints" method="get" action="{{url('resultados')}}">
				    <?php $category = $request->input('category') ? $categories->where("name", $request->input('category'))->first() : null; ?>
				    {!! csrf_field() !!}
				    <p>Título: <input type="text" name="title" value="{{$request->input('title')}}"></p>

				    <p>
              <select name="category" id="survey-category">
                <option value="">Selecciona una categoría</option>
                @foreach($categories as $cat)
                <option value="{{$cat->name}}" {{$category && $category->name == $cat->name ? 'selected' : ''}}>{{$cat->name}}</option>
                @endforeach
              </select>
            </p>

            <!-- SUBCATEGORY -->
            <div>
              <p>Subcategoría</p>
              <ul id="sub-list">
              @if($category)
                @foreach($category->sub as $sub)
                <label><input type="checkbox" value="{{$sub}}" name="survey-subs[]"> {{$sub}}</label>
                @endforeach
              @endif
              </ul>
              <!-- survey-tags-->
            </div>

             <!-- TAGS -->
            <div>
              <p>Etiquetas</p>
              <ul id="tag-list">
              @if($category)
                @foreach($category->tags as $tag)
                <label><input type="checkbox" value="{{$tag}}" name="survey-tags[]"> {{$tag}}</label>
                @endforeach
              @endif
              </ul>
              <!-- survey-tags-->
            </div>
            <p><input type="submit" value="Filtrar resultados"></p>
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