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
<div class="row top-buffer">
	<div class="col-md-8">
		<h1>Datos Abiertos</h1>
		<hr class="red">

        @if ($surveys->count() > 0)
          @foreach($surveys as $survey)
    	  <h3><a href="{{ url('resultado/'. $survey->id)}}">{{ $survey->title}}</a></h3>
    	  <p>
    	    <a href="{{url('csv/' . $survey->csv_file . '.xlsx')}}" class="btn btn-primary btn-sm">XLSX</a>
    	    <a href="{{url('csv/' . $survey->csv_file . '.csv')}}" class="btn btn-primary btn-sm">CSV</a>
    	  </p>
    	  <div class="row">
			<div class="col-md-8">
				<a href="{{$survey->ptp}}" class="btn btn-primary">Conoce el desempeño del programa presupuestario</a>
			</div>
		  </div>
  		  @endforeach
  		  
  		  <ul id="pagination">
            @for($i = 1; $i <= $pages; $i++)
            <li>
              <a href="{{url('datos-abiertos/' . $i) . '?' . http_build_query($request->all())}}" {{$page == $i ? 'class="current"' : ''}}>{{$i}}</a>
            </li>
            @endfor
          </ul>
        @else
        <p>Aún no hay datos abiertos disponibles :(</p>
        @endif
        <hr>
	</div>
</div>
@endsection