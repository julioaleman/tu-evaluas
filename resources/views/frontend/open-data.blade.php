@extends('layouts.master')

@section('content')
<hr>
<div class="container.vertical-buffer">
	<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<h2 class="intro">Datos abiertos en <strong>Tú Evalúas</strong><br><br></h2>
		<hr class="red">
        @if ($surveys->count() > 0)
          @foreach($surveys as $survey)
          <hr>
    	  <h2><a href="{{ url('resultado/'. $survey->id)}}">{{ $survey->title}}</a></h2>
    	  <p><a href="{{$survey->ptp}}">programa presupuestario</a></p>
    	  <p>
    	    <a href="{{url('csv/' . $survey->csv_file . '.xlsx')}}">xlsx</a>
    	    <a href="{{url('csv/' . $survey->csv_file . '.csv')}}">csv</a>
    	  </p>
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
</div>
@endsection