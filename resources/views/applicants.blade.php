@extends('layouts.master_admin')

@section('content')
<div class="container">
  <div class="row">
<!-- [A] envía una a algún correo -->
  <form id="mail-to-someone" action="{{url('dashboard/encuestados/enviar/uno')}}" method="post" class="col-sm-12">
    {!! csrf_field() !!}
    <div class="col-md-12">
    	<h1 class="title">Envía encuesta a un correo</h1>
    </div>
    <div class="col-sm-8 col-sm-offset-2">
		<p>
			Correo
		<input name="email" type="text"> 
		</p>
		<p> Selecciona encuesta:<br>	
		<select name="id">
      @foreach($blueprints as $bp)
      <option value="{{$bp->id}}">{{$bp->title}}</option>
      @endforeach
    </select>
		</p>
		<p>
			<input type="submit" value="Enviar Encuesta">
		</p>
    </div>
  </form>
  </div>
</div>
@endsection