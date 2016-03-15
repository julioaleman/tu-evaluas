<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

<!-- [A] envía una a algún correo -->
  <form id="mail-to-someone" action="{{url('dashboard/encuestados/enviar/uno')}}" method="post" class="col-sm-12">
    {!! csrf_field() !!}
    <h3>Envía formulario a un correo</h3>
    <input name="email" type="text"> 
    <select name="id">
      @foreach($blueprints as $bp)
      <option value="{{$bp->id}}">{{$bp->title}}</option>
      @endforeach
    </select>
    <input type="submit" value="enviar">
  </form>

</body>
</html>