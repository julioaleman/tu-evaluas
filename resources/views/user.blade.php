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
                <p>
                  <label>Ramo</label>
                  <select name="branch" id="branch">
                    <option value="">Selecciona un ramo</option>
                  </select>
                </p>
                <p>
                  <label>Unidad responsable</label>
                  <select name="unit" id="unit">
                    <option value="">Selecciona una unidad responsable</option>
                  </select>
                </p>

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

<script src="{{url('js/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{url('js/bower_components/d3/d3.js')}}"></script>
<script src="{{url('js/bower_components/underscore/underscore.js')}}"></script>
<script src="{{url('js/bower_components/backbone/backbone.js')}}"></script>
<script src="{{url('js/bower_components/sweetalert/dist/sweetalert.min.js')}}"></script>
<script>
$(document).ready(function(){
  var user = <?php echo json_encode($_user); ?>,
      path = "{{url('')}}" + "/js/ramos.json",
      ramos, units, ramo; 

$("#branch").on("change", function(e){
  var val = e.currentTarget.value;
  if(val){
    ramo  = ramos.findWhere({nombre : val});
    units = ramo.get('unidades');
    $(".remove-me").remove();
    units.forEach(function(u){
      $("#unit").append("<option class='remove-me'>" + u + "</option>");
    }, this);
  }
});

d3.json(path, function(error, data){
  ramos = new Backbone.Collection(data);
  ramos.each(function(r){
    var selected = r.get("nombre") == user.branch ? " selected" : "";
    $("#branch").append("<option" + selected + ">" + r.get('nombre') + "</option>");
  });

  ramo  = ramos.findWhere({nombre : user.branch});
  if(ramo){
    units = ramo.get('unidades');
    units.forEach(function(u){
      var selected = ramo.get("nombre") == user.branch && u == user.unit ? " selected" : "";
      $("#unit").append("<option class='remove-me' " + selected + ">" + u + "</option>");
    }, this);
  }
});

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