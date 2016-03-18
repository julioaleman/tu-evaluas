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
					<h2 class="toggle">Filtrar resultados</h2>
<<<<<<< HEAD
					<form style="display: none" id="fbp" name="filter-blueprints" method="get" action="{{url('resultados')}}" class="form_search">
				    	<?php $category = $request->input('category') ? $categories->where("name", $request->input('category'))->first() : null; ?>
						{!! csrf_field() !!}
						<div class="row">
							<div class="divider"></div>
							<div class="col-sm-2">
							<h3>Título: </h3>
							</div>
							<div class="col-sm-10">
								<input type="text" name="title" value="{{$request->input('title')}}" class="advanced_search">
							</div>
						</div>
						
						<div class="row">
							<div class="divider"></div>
							<div class="col-sm-4">
								<h3>Categoría</h3>
								<select name="category" id="survey-category">
								  <option value="">Selecciona una categoría</option>
								  @foreach($categories as $cat)
								  <option value="{{$cat->name}}" {{$category && $category->name == $cat->name ? 'selected' : ''}}>{{$cat->name}}</option>
								  @endforeach
								</select>
							</div>
							
							<!-- SUBCATEGORY -->
							<div class="col-sm-4">
								<h3>Subcategoría</h3>
								<ul id="sub-list">
									@if($category)
									  @foreach($category->sub as $sub)
									  <li><label><input type="checkbox" value="{{$sub}}" name="survey-subs[]" {{in_array($sub, $request->input('survey-subs', [])) ? 'checked' : ''}}> {{$sub}}</label></li>

									  @endforeach
									@endif
								</ul>
							</div>
							
							<!-- TAGS -->
							<div class="col-sm-4">
								<h3>Etiquetas</h3>
								<ul id="tag-list">
              						@if($category)
              						  @foreach($category->tags as $tag)
              						  <li><label><input type="checkbox" value="{{$tag}}" name="survey-tags[]" {{in_array($tag, $request->input('survey-tags', [])) ? 'checked' : ''}}> {{$tag}}</label></li>
              						  @endforeach
              						@endif
              					</ul>
							</div>
						</div>
						<div class="row">
							<div class="divider"></div>
                        	<div class="col-sm-8">
	                        	<input type="submit" value="Filtrar resultados" class="btn">
                        	</div>
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

						<ul id="pagination">
							@for($i = 1; $i <= $pages; $i++)
							<li><a href="{{url('resultados/' . $i) . '?' . http_build_query($request->all())}}" {{$page == $i ? 'class="current"' : ''}}>{{$i}}</a></li>
							@endfor
						</ul>
					@else 
						<h2>Estamos trabajando para mejorar la descarga de los resultados de las encuestas. ¡Pronto estaremos de vuelta!</h2>
					@endif
				</section>
			</div>			
		</article>
	</div>
</div>

<script src="{{url('js/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script>
  $(document).ready(function(){
  	var categories = <?php echo json_encode($categories); ?>;
  	
  	$('.toggle').on('click', function(e){
  		$("#fbp").slideToggle();
  	});

  	$('#survey-category').on('change', function(e){
  		var value = e.currentTarget.value, 
  		   category = categories.filter(function(cat){
  			   return cat.name == value;
  		   })[0];

  		// CLEAR LISTS
  		$("#sub-list").html("");
  		$("#tag-list").html("");

  		if(value){
  			category.sub.forEach(function(sub){
  				$("#sub-list").append('<li><label><input type="checkbox" value="' + sub + '" name="survey-tags[]"> ' + sub + '</label></li>');
  			});
  			category.tags.forEach(function(tag){
  				$("#tag-list").append('<li><label><input type="checkbox" value="' + tag + '" name="survey-tags[]"> ' + tag + '</label></li>');
  			});
  		}
  		else{
  			$("#sub-list").append("<li>Selecciona una categoría</li>");
  			$("#tag-list").append("<li>Selecciona una categoría</li>");
  		}

  	});

  });
</script>

@endsection