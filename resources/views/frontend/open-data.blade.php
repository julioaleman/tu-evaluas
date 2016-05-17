@extends('layouts.master')

@section('content')
<!--breadcrumb-->
<div class="row">
	<div class="col-sm-8">
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="icon icon-home"></i></a></li>
	    <li><a href="https://www.gob.mx">Inicio</a></li>
	    <li><a href="{{ url('')}}">Tú Evalúas</a></li>
        <li class="active">Datos Abiertos</li>
	  </ol>
	</div>
</div>
<div class="container vertical-buffer">
	<div class="col-md-8">
		<h2>Datos Abiertos</h2>
		<hr class="red">
	</div>
	<div class="col-md-8">
        @if ($surveys->count() > 0)
        <table class="table table-striped">
            <thead clas="thead-default">
              <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Descarga</th>
              </tr>
            </thead>
			<tbody>
			@foreach($surveys as $survey)
          	<tr onclick="location='{{ url('resultado/'. $survey->id)}}'">
	          	<td>{{ $survey->title}}</td>
			  	<td>{{ $survey->category }}</td>
			  	<td>
				  	<a href="{{url('csv/' . $survey->csv_file . '.xlsx')}}" class="btn btn-link btn-sm">XLSX</a>
				  	<a href="{{url('csv/' . $survey->csv_file . '.csv')}}" class="btn btn-link btn-sm">CSV</a>
			  	</td>
          	</tr>
  		  @endforeach
          </tbody>
        </table>
  		<ul id="pagination" class="pagination">
          @for($i = 1; $i <= $pages; $i++)
          <li>
            <a href="{{url('datos-abiertos/' . $i) . '?' . http_build_query($request->all())}}" {{$page == $i ? 'class="current"' : ''}}>{{$i}}</a>
          </li>
          @endfor
        </ul>
        @else
        <p>Aún no hay datos abiertos disponibles :(</p>
        @endif
	</div>
</div>
@endsection