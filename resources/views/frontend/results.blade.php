@extends('layouts.master')

@section('content')
<!--breadcrumb-->
<div class="row">
	<div class="col-sm-8">
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="icon icon-home"></i></a></li>
	    <li><a href="https://www.gob.mx">Inicio</a></li>
	    <li><a href="{{ url('')}}">Tú Evalúas</a></li>
        <li class="active">Resultados</li>
	  </ol>
	</div>
</div>
<div class="bottom-buffer">
	<div class="row">
		<div class="col-md-8">
			<h2>Resultados en cuestionarios <strong>Tú Evalúas</strong></h2>
			<hr class="red">
		</div>
	</div>
</div>
<div class="col-md-8">
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
  							<div  align="center" class="col-md-2">Busca por atención: </div>
  							<div class="col-md-9">

	  							<input class="form-control" name="title" placeholder="Palabra clave" type="text" value="{{$request->input('title')}}" >
	  						</div>
                		</div>
						<hr>
						<div class="row" align="center">
							<div class="col-md-4">
							  <select name="category" id="survey-category" class="form-control">
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $cat)
                                <option value="{{$cat->name}}" {{$category && $category->name == $cat->name ? 'selected' : ''}}>{{$cat->name}}</option>
                                @endforeach
                              </select>
							<?php /* LO QUE DEBERÍA BORRAR: 
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									Categoría<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										@foreach($categories as $cat)
										<li><a href="#">{{$cat->name}}</a></li>
										@endforeach
									</ul>
									*/ ?>
							</div>
							<div class="col-md-4">
							  <p>Subcategoría</p>
							  <ul id="sub-list">
							  @if($category)
							    @foreach($category->sub as $sub)
							    <li><label><input type="checkbox" value="{{$sub}}" name="survey-subs[]" {{in_array($sub, $request->input('survey-subs', [])) ? 'checked' : ''}}> {{$sub}}</label></li>
							    @endforeach
							  @endif
							  </ul>
							  <!--
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									Subcategoría<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										@if($category)
										@foreach($category->sub as $sub)
										<li><a href="#">{{$sub}} </a></li>
										@endforeach
										@endif
									</ul>
									-->
							</div>
							<div class="col-md-4">
							  <p>Etiquetas</p>
							  <ul id="tag-list">
							  @if($category)
							    @foreach($category->tags as $tag)
							    <li><label><input type="checkbox" value="{{$tag}}" name="survey-tags[]" {{in_array($tag, $request->input('survey-tags', [])) ? 'checked' : ''}}> {{$tag}}</label></li>
							    @endforeach
							  @endif
							  </ul>
							<!--
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									Etiquetas<span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
								@if($category)
              					  @foreach($category->tags as $tag)
									<li><a href="#">{{$tag}}</a></li>
									@endforeach
									@endif
								</ul>
								-->
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
		</div>
		<div class="bottom-buffer">
            <div class="col-md-8">
        @foreach($surveys as $survey)
    	<h2 class="vertical-buffer"><a href="{{ url('resultado/'. $survey->id)}}">{{ $survey->title}}</a></h2>
  		<button type="button" class="btn btn-primary">Consultar Resultados</button>
        <hr>
  		@endforeach
        @endif
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
  		console.log(e);
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