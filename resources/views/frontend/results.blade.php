@extends('layouts.master')

@section('content')

<div class="row">
	<div class="col-md-8">
		<p><strong>Tú Evalúas</strong> es una plataforma digital que <strong>tiene como objetivo evaluar el desempeño</strong> de los programas públicos federales mediante la participación ciudadana. A través de <strong>Tú Evalúas</strong> podrás calificar los procesos seguidos  por cada programa y expresar tu 
       <strong>satisfacción con los productos y servicios</strong> que ofrecen.</p>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<h2>Resultados</h2>
		<hr class="red">
	</div>
</div>
@if ($surveys->count() > 0)
<div class="bottom-buffer">
	<div class="col-md-8">
		<form id="fbp" name="filter-blueprints" method="get" action="{{url('resultados')}}" class="form_search">
			<?php $category = $request->input('category') ? $categories->where("name", $request->input('category'))->first() : null; ?>
			{!! csrf_field() !!}
        <div class="panel-group ficha-collapse" id="accordion">
	    	<div class="panel panel-default">
				<div class="panel-heading">
			  		<h4 class="panel-title">
			  			<a data-parent="#accordion" data-toggle="collapse" href="#panel-01" aria-expanded="true" aria-controls="panel-01">
			  			Filtrar
        				</a>
      				</h4>
	  				<button type="button" class="collpase-button collapsed" data-parent="#accordion" data-toggle="collapse" href="#panel-01"></button>
    			</div>
				<div class="panel-collapse collapse in" id="panel-01">
					<div class="panel-body">
  						<div class="row">
  							<div class="col-md-2">Busca por atención: </div>
  							<div class="col-md-10">

	  							<input class="form-control" name="title" placeholder="Palabra clave" type="text" value="{{$request->input('title')}}" >
	  						</div>
                		</div>
						<hr>
						<div class="row">
							<div class="col-md-6">
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
							<div class="col-md-3">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Subcategoría<span class="caret"></span></a>
							  <ul id="sub-list" class="dropdown-menu" role="menu">
							  @if($category)
							    @foreach($category->sub as $sub)
							    <li><label><input type="checkbox" value="{{$sub}}" name="survey-subs[]" {{in_array($sub, $request->input('survey-subs', [])) ? 'checked' : ''}}> {{$sub}}</label></li>
							    @endforeach
							  @endif
							  </ul>
							</div>
							<div class="col-md-3">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Etiquetas<span class="caret"></span></a>
							  <ul id="tag-list" class="dropdown-menu" role="menu">
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
                            <div class="pull-left">
								<button type="button" class="btn btn-primary">Filtrar resultados</button>
						    </div>
						</div>
					</div>
				</div>
			</div>
        </div>
		</form>
                        <hr>
	</div>
</div>
<!-- tabala de resultados-->
<div class="col-md-8">
	<table class="table table-striped table-hover">
		<thead>
          <tr>
            <th>Nombre</th>
            <th>Categoria</th>
            <th>Estatus</th>
          </tr>
        </thead>
        <tbody>
    		@foreach($surveys as $survey)
    		<tr onclick="location='{{ url('resultado/'. $survey->id)}}'">
	    		<td>{{ $survey->title }}</td>
                <td>{{ $survey->category }}</td>
                <td>{{ $survey->is_closed == 0 ? 'Abierta' : 'Cerrada' }}</td>
    		</tr>
			@endforeach
        </tbody>
	</table>
</div>

@else
<div class="col-md-8">
    <p>Estamos actualizando los resultados de los cuestionarios, pronto más información.</p>
    <hr>
</div>

@endif

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