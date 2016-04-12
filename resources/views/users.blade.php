@extends('layouts.master_admin')

@section('content')

<div class="container">
  <div class="row">
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
  @if($status['type'] == "delete")
    <p>Se ha eliminado "{{$status['name']}}"; Si tenía cuestionarios, 
    estos son visibles por cualquier adminsitrador.</p>  
  @elseif($status['type'] == "create")
    <p>has agregado a "{{$status['name']}}" al sistema :D</p>  
  @elseif($status['type'] == "update")
    <p>has editado los datos de "{{$status['name']}}" :)</p>  
  @else
    <p>Hubo un error al crear "{{$status['name']}}"</p> 
  @endif
  </div>
@endif
<!-- ERROR / SUCCESS MESSAGE -->
	
	<h1 class="title">{{$user->level == 3 ? "Usuarios" : "Tu Información" }}</h1>
    <div class="row">
    	@if($user->level == 3)
		<!-- add users-->
		<div class="col-sm-4">  
        	<section class="box">
				<h2>Buscar Usuario</h2>
				<!-- SEARCH USERS -->
				@if($user->level == 3)
				<form id="search-user" name="search-user" method="post" class="row" action="{{url('dashboard/usuarios/buscar/json')}}">
				  {!! csrf_field() !!}
				  <div class="col-sm-12">
				    <p><label>Buscar usuario (email): </label> 
				      <input type="text" name="query" class="typeahead">
				    </p>
				  </div>
				</form>
				@endif
				<!-- SEARCH USERS ENDS -->
			</section>

        	<section class="box">
				<form name="add-admin" method="post" class="row" id="add-admin-form" action="{{url('dashboard/usuarios/crear')}}">
          		  {!! csrf_field() !!}
          		  <h2>Crear usuario</h2>
          		  <div class="col-sm-12">
          		  <p><label>Nombre</label><input id="the-new-name" type="text" name="name" value="{{old('name')}}"></p>
          		  <p><label>Correo</label><input id="the-new-email" type="text" name="email" value="{{old('email')}}"></p>
          		  <p><label>Contraseña</label><input id="the-new-pass" type="password" name="password"></p>
          		  <p>Tipo de usuario</p>
          		  <ul class="options">
          		    <li><label><input type="radio" name="level" value="2" checked>Funcionario</label></li>
          		    <li><label><input type="radio" name="level" value="3">Administrador</label></li>
          		  </ul>
          		  <p><input type="submit" value="crear usuario"></p>
          		  </div>
          		</form>
			</section>
			
      </div>
      @endif
      
      @if($user->level == 3)
      <!--  admins list-->
      <div class="col-sm-8">  
        <section class="box">
          <h2>Administradores</h2>
          <h3>Total
              <strong>{{$admins->count()}}</strong>
            </h3>
           <ul class="list">
            <li class="row los_titles">
               <div class="col-sm-6">
                   <h4>Nombre</h4>
               </div>
               <div class="col-sm-6">
                    <h4>Correo</h4>
               </div>
            </li>

          @foreach($admins as $admin)
            <li class="row">
              <div class="col-sm-6">
               <a href="{{url('dashboard/usuario/' . $admin->id)}}">{{$admin->name}}</a>
              </div>
              <div class="col-sm-6">{{$admin->email}}</div>
            </li>
          @endforeach
          </ul>
        </section>
      </div>
	  @endif
	  
      <!--  users list-->
      <div class="col-sm-8">  
        <section class="box">
	        @if($user->level == 3)
			<h2>Funcionarios Públicos</h2>
			<h3>Total
			    <strong>{{$users->count()}}</strong>
			  </h3>
            @else
            <h2>Tu Perfil</h2>
			
            @endif
           <ul class="list">
		  @if($user->level == 3)
          	
            <li class="row los_titles">
               <div class="col-sm-6">
                   <h4>Nombre</h4>
               </div>
               <div class="col-sm-6">
                    <h4>Correo</h4>
               </div>
            </li>
          	@foreach($users as $user_fun)
          	  <li class="row">
          	    <div class="col-sm-6">
          	     <a href="{{url('dashboard/usuario/' . $user_fun->id)}}">{{$user_fun->name}}</a>
          	    </div>
          	    <div class="col-sm-6">{{$user_fun->email}}</div>
          	  </li>
          	@endforeach
          @else
          	<li class="row los_titles">
               <div class="col-sm-4">
                   <h4>Nombre</h4>
               </div>
               <div class="col-sm-4">
                    <h4>Correo</h4>
               </div>
                <div class="col-sm-4">
                    <h4>Tipo de Usuario</h4>
               </div>
            </li>
          	<li class="row">
              <div class="col-sm-4">
               <a href="{{url('dashboard/usuario/' . $user->id)}}">{{$user->name}}</a>
              </div>
              <div class="col-sm-4">{{$user->email}}</div>
              <div class="col-sm-4">
                    <p>Funcionario público</p>
               </div>
            </li>
          @endif
          </ul>
        </section>
      </div>


    </div>
  </div>
</div>

<script src="/js/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/js/bower_components/typeahead.js/dist/typeahead.jquery.min.js"></script>
<script src="/js/bower_components/typeahead.js/dist/bloodhound.min.js"></script>
<script src="/js/bower_components/sweetalert/dist/sweetalert.min.js"></script>

<script>
  /*
   * ENABLE THE USERS AND SURVEY SEARCH
   *
   */
  $(document).ready(function(){

    // THE USERS SEARCH
    //
    //
    //
    var users = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      // prefetch: $("#search-survey").attr("action"),
      
      remote: {
        url: $("#search-user").attr("action"),
        prepare : function(a, b){
          var base = $("#search-user").attr("action"),
              full = base + "?query=" + a;

          b.url = full;
          return b;
        }

      }
      
    });

    $('#search-user .typeahead').typeahead(null, {
      name: 'query',
      display: 'email',
      source: users
    });

    $('.typeahead').bind('typeahead:select', function(ev, suggestion){
      console.log(suggestion);
      if(suggestion.email){
        window.location.href = "{{url('dashboard/usuario')}}/" + suggestion.id;
      }
      else{
        window.location.href = "{{url('dashboard/encuestas')}}/" + suggestion.id;
      }
    });
  });
</script>


<script>
/*
  // more crapy validation
  var form = document.getElementById('add-admin-form'),
      error = document.getElementById('error-message');

  form.onsubmit = function(e){
    e.preventDefault();
    var email = document.getElementById('the-new-email'),
        pass  = document.getElementById('the-new-pass');

    email.className = '';
    pass.className = '';
    error.innerHTML = "";

    if(! email.value){
      email.className = 'error'; 
      error.innerHTML = "el campo de correo está vacío :(";
      return;
    }
    if(pass.value.length < 8){
      pass.className = 'error'; 
      error.innerHTML = "mínimo 8 caracteres para la contraseña por favor!";
      return;
    } 
   
    this.submit();
  }
  */
</script>


@endsection