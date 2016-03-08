@extends('layouts.master_admin')

@section('content')

<div class="container">
  <div class="row">
<!-- ERROR / SUCCESS MESSAGE -->
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


      <h1 class="title">Usuarios</h1>
    <div class="row">
      <!-- add users-->
      <div class="col-sm-4">  
        <section class="box">

          <form name="add-admin" method="post" class="row" id="add-admin-form" action="{{url('dashboard/usuarios/crear')}}">
            {!! csrf_field() !!}
            <h2>Crear usuario</h2>
            <div class="col-sm-12">
            <p><label>nombre</label><input id="the-new-name" type="text" name="name" value="{{old('name')}}"></p>
            <p><label>correo</label><input id="the-new-email" type="text" name="email" value="{{old('email')}}"></p>
            <p><label>contraseña</label><input id="the-new-pass" type="password" name="password"></p>
            <p>Tipo de usuario</p>
            <ul class="options">
              <li><label><input type="radio" name="level" value="2">funcionario</label></li>
              <li><label><input type="radio" name="level" value="3">administrador</label></li>
            </ul>
            <p><input type="submit" value="crear usuario"></p>
            </div>
          </form>

        </section>
      </div>
      <!--  admins list-->
      <div class="col-sm-8">  
        <section class="box">
          <h2>Administradores</h2>
          <h3>Total
              <strong>{{$admins->count()}}</strong>
            </h3>
           <ul class="list">
            <li class="row los_titles">
               <div class="col-sm-8">
                   <h4>Nombre</h4>
               </div>
               <div class="col-sm-4">
                    <h4>Correo</h4>
               </div>
            </li>

          @foreach($admins as $admin)
            <li class="row">
              <div class="col-sm-8">
               <a href="{{url('dashboard/usuario/' . $admin->id)}}">{{$admin->name}}</a>
              </div>
              <div class="col-sm-4">{{$admin->email}}</div>
            </li>
          @endforeach
          </ul>
        </section>
      </div>

      <!--  users list-->
      <div class="col-sm-8">  
        <section class="box">
          <h2>Funcionarios</h2>
          <h3>Total
              <strong>{{$users->count()}}</strong>
            </h3>
           <ul class="list">
            <li class="row los_titles">
               <div class="col-sm-8">
                   <h4>Nombre</h4>
               </div>
               <div class="col-sm-4">
                    <h4>Correo</h4>
               </div>
            </li>

          @foreach($users as $user)
            <li class="row">
              <div class="col-sm-8">
               <a href="{{url('dashboard/usuario/' . $user->id)}}">{{$user->name}}</a>
              </div>
              <div class="col-sm-4">{{$user->email}}</div>
            </li>
          @endforeach
          </ul>
        </section>
      </div>


    </div>
  </div>
</div>
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