@extends('layouts.master_admin')

@section('content')
<div class="container">
  <div class="row">
  	<h1 class="title">Enviar encuestas</h1>
  	
<!-- ERROR / SUCCESS MESSAGE -->
@if(count($errors) > 0)
  <div class="alert">
    <ul>
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
  </div>
@endif

@if($status)
  <div class="{{$status['type']}}"> 
  @if($status['type'] == "create")
    <p>{{$status['name']}}</p>  
  @endif
  </div>
@endif
 <!-- ERROR / SUCCESS MESSAGE ENDS -->

  	<p>Para enviar las encuestas, <strong>Tú Evalúas</strong> tiene tres métodos diferentes:</p>
  
  	<!-- [A] envía una a algún correo -->
    <div class="col-sm-4">
	    <section class="box">
			<h2>Envía encuesta a un correo</h2>
			<form id="mail-to-someone" action="{{url('dashboard/encuestados/enviar/uno')}}" method="post" class="col-sm-12">
			  {!! csrf_field() !!}
			  
          <p>
            Encabezado
          <input name="header" type="header"> 
          </p>
			  	<p> Selecciona encuesta:<br>	
			  	<select name="id">
			    @foreach($blueprints as $bp)
			    <option value="{{$bp->id}}">{{$bp->title}}</option>
			    @endforeach
			  </select>
			  	</p>

          <p>
            Correo
          <input name="email" type="email"> 
          </p>

			  	<div class="divider"></div>
			  	<p>
			  		<input type="submit" value="Enviar Encuesta">
			  	</p>
			</form>
			<div class="clearfix"></div>
	    </section>
	</div>
	
	<!-- [C] Envía el correo a una lista de usuarios  -->
    <div class="col-sm-4">
	    <section class="box">
		<h2>Envía la invitación a una lista de correos</h2>
		<form id="sent-to-all" enctype="multipart/form-data" action="{{url('dashboard/encuestados/enviar/todos')}}" method="post" class="col-sm-12">
		  {!! csrf_field() !!}
      <p>
            Encabezado
          <input name="header" type="text"> 
          </p>
		  <p><strong>Selecciona encuesta</strong>:<br>  
		  <select name="id">
		    @foreach($blueprints as $bp)
		    <option value="{{$bp->id}}">{{$bp->title}}</option>
		    @endforeach
		  </select>
		  </p>
		  <p>Lista de correos <br>
		    <span class="instructions">(debe ser un archivo de texto/csv con la lista de correos, un correo por renglón)</span> <br><br>
		    <input type="file" name="list">
		  </p>
		  
		  	<div class="divider"></div>
		  <p>
		    <input type="submit" value="Enviar a todos los correos">
		  </p>
		</form>
		<div class="clearfix"></div>
	    </section>
  	</div>
  	
	<!-- [B] Genera El archivo con los links  -->
    <div class="col-sm-4">
	    <section class="box">
		    <h2>Genera una lista de links para enviar</h2>
			<form id="make-file" action="{{url('dashboard/encuestados/crear/archivo')}}" method="post" class="col-sm-12">
			  {!! csrf_field() !!}
			  <p><strong>Selecciona encuesta</strong>:<br>  
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
			</form>
		<div class="clearfix"></div>
	    </section>
  	</div>

  	
  </div>
</div>
@endsection