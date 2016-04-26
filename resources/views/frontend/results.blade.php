@extends('layouts.master')

@section('content')
<hr>
<div class="container.vertical-buffer">
	<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<h2 class="intro">Resultados en cuestionarios <strong>Tú Evalúas</strong><br><br></h2>
		<hr class="red">
        @if ($surveys->count() > 0)
		<form id="fbp" name="filter-blueprints" method="get" action="{{url('resultados')}}" class="form_search">
			<?php $category = $request->input('category') ? $categories->where("name", $request->input('category'))->first() : null; ?>
			{!! csrf_field() !!}
        <div class="panel-group ficha-collapse" id="accordion">
	    	<div class="panel panel-default">
				<div class="panel-heading">
			  		<h4 class="panel-title">
			  			<a data-parent="#accordion" data-toggle="collapse" href="#panel-01" aria-expanded="true" aria-controls="panel-01">
			  			Filtrar Resultados
        				</a>
      				</h4>
	  				<button type="button" class="collpase-button collapsed" data-parent="#accordion" data-toggle="collapse" href="#panel-01"></button>
    			</div>
				<div class="panel-collapse collapse in" id="panel-01">
					<div class="panel-body">
  						<div class="row">
  							<div  align="center" class="col-md-2">Título: </div>
  							<div class="col-md-9">
	  							<input class="form-control" name="title" placeholder="Título de la encuesta" type="text" value="{{$request->input('title')}}" >
	  						</div>
                		</div>
						<hr>
						<div class="row" align="center">
							<div class="col-md-4">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									Categoría<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										@foreach($categories as $cat)
										<li><a href="#">{{$cat->name}}</a></li>
										@endforeach
									</ul>
							</div>
							<div class="col-md-4">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									Subcategoría<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										@if($category)
										@foreach($category->sub as $sub)
										<li><a href="#">{{$sub}} </a></li>
										@endforeach
										@endif
									</ul>
							</div>
							<div class="col-md-4">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									Etiquetas<span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
								@if($category)
              					  @foreach($category->tags as $tag)
									<li><a href="#">{{$tag}}</a></li>
									@endforeach
									@endif
								</ul>
							</div>
						</div>        
						<hr>
						<div class="bottom-buffer">
							<div align="right" class="col-md-2">
								<button type="button" class="btn btn-primary">Filtrar Resultados</button>
						    </div>
						</div>
					</div>
				</div>
			</div>
        </div>
		</form>
        @foreach($surveys as $survey)
        <hr>
    	<h2><a href="{{ url('resultado/'. $survey->id)}}">{{ $survey->title}}</a></h2>
    	<div align="center" class="vertical-buffer">
    		<a href="{{url('resultado/'. $survey->id) }}">
			<img src="{{url('img/programas/'.(empty($survey->banner) ? "default.jpg":$survey->banner))}}">
			</a>
        </div>
  		<button type="button" class="btn btn-primary">Consultar Resultados</button>
  		@endforeach
        @endif
        <hr>
	</div>
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