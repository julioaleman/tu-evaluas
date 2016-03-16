@extends('layouts.master_admin')

@section('content')
<div class="container">
  <div class="row">
  	
  	<!-- [A] envía una a algún correo -->
    <div class="col-md-6">
		<form id="mail-to-someone" action="{{url('dashboard/encuestados/enviar/uno')}}" method="post" class="col-sm-12">
		  {!! csrf_field() !!}
		  <div class="col-md-12">
		  	<h1 class="title">Envía encuesta a un correo</h1>
		  
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
		  	<div class="divider"></div>
		  	<p>
		  		<input type="submit" value="Enviar Encuesta">
		  	</p>
		  </div>
		</form>
	</div>

	<!-- [B] Genera El archivo con los links  -->
    <div class="col-md-6">
		<form id="make-file" action="{{url('dashboard/encuestados/crear/archivo')}}" method="post" class="col-sm-12">
		  {!! csrf_field() !!}
		  <div class="col-md-12">
		    <h1 class="title">Genera una lista de links para enviar</h1>
		  <p> Selecciona encuesta:<br>  
		  <select name="id">
		    @foreach($blueprints as $bp)
		    <option value="{{$bp->id}}">{{$bp->title}}</option>
		    @endforeach
		  </select>
		  </p>
		  <p>
		    Número de cuestionarios por generar <br>
		    <input name="total" type="text">
		  </p>
		  <p>
		    tipo de archivo <br>
		    <select name="type">
		      <option value="csv">CSV</option>
		      <option value="xlsx">XLSX</option>
		    </select>
		  </p>
		  	<div class="divider"></div>
		  <p>
		    <input type="submit" value="Generar lista">
		  </p>
		  </div>
		</form>
  	</div>

  	<!-- [C] Envía el correo a una lista de usuarios  -->
    <div class="col-md-6">
		<form id="sent-to-all" enctype="multipart/form-data" action="{{url('dashboard/encuestados/enviar/todos')}}" method="post" class="col-sm-12">
		  {!! csrf_field() !!}
		  <div class="col-md-12">
		    <h1 class="title">Envía la invitación a una lista de correos</h1>
		  <p> Selecciona encuesta:<br>  
		  <select name="id">
		    @foreach($blueprints as $bp)
		    <option value="{{$bp->id}}">{{$bp->title}}</option>
		    @endforeach
		  </select>
		  </p>
		  <p>
		    Lista de correos <br>
		    (debe ser un archivo de texto/csv con la lista de correos, un correo por renglón) <br>
		    <input type="file" name="list">
		  </p>
		  
		  	<div class="divider"></div>
		  <p>
		    <input type="submit" value="Enviar a todos los correos">
		  </p>
		  </div>
		</form>
  	</div>
  </div>
</div>
@endsection