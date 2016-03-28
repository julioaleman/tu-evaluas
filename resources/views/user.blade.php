@extends('layouts.master_admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
    <h1 class="title">Editar usuario</h1>
    </div>
  </div>
  <form name="add-admin" method="post" class="row" id="add-admin-form" action="{{url('dashboard/usuario/' . $_user->id)}}">
    {!! csrf_field() !!}
    <div class="col-sm-8 col-sm-offset-2">
              
            <p>Correo: <em>{{$_user->email}}</em></p>
            <p><label>nombre</label><input id="the-new-name" type="text" name="name" value="{{$_user->name}}"></p>
            <p><label>contraseña</label><input id="the-new-pass" type="password" name="password">
              <br><span>El password debe tener por lo menos ocho caracteres</span>
            </p>
			@if($user->level == 3)
            <p>Tipo de usuario</p>
            <ul class="options">
              <li><label>
              <input type="radio" name="level" value="2" {{$_user->level == '2' ? 'checked' : ''}}>funcionario
              </label></li>
              <li><label>
              <input type="radio" name="level" value="3" {{$_user->level >= '3' ? 'checked' : ''}}>administrador
              </label></li>
            </ul>
            @endif
            <p>
              <input type="submit" value="editar">
              @if($user->id != $_user->id)
              <a data-title="{{$_user->email}}" id="kill-him" href="{{url('dashboard/usuario/eliminar/' . $_user->id)}}">Eliminar!</a>
              @endif
            </p>
            </div>
  </form>
</div>

<script src="/js/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/js/bower_components/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function(){

    // DELETE SURVEY WARNING
    //
    //
    //
    $("#kill-him").on("click", function(e){
      e.preventDefault();
      var url   = $(this).attr("href"),
          title = $(this).attr("data-title");
      deleteSurvey(url, title);
    });

    function deleteSurvey(url, title){
      swal({
        title: "Eliminar usuario", 
        text: "Vas a eliminar \"" + title + "\" del sistema. Esto no se puede deshacer!", 
        type: "warning",
        confirmButtonText : "Eliminar",
        //confirmButtonColor: "#ec6c62"
        showCancelButton: true,
        cancelButtonText : "Mejor no",
      }, function(){
        window.location.href = url;
      });
    }
});
</script>
@endsection