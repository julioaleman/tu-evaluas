@extends('layouts.master_admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">

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
    <p>Se ha eliminado "{{$status['name']}}"</p>  
  @elseif($status['type'] == "create")
    <p>Se ha creado "{{$status['name']}}"</p>  
  @else
    <p>Se actualizó "{{$status['name']}}"</p> 
  @endif
  </div>
@endif
<!-- ERROR / SUCCESS MESSAGE -->



      <h1 class="title">Autorizaciones</h1>

      <h2>Por autorizar</h2>
      <ul></ul>
      <h2>Autorizadas/rechazadas</h2>
      <ul></ul>

    </div>
  </div>
</div>

<!--<script src="/js/bower_components/jquery/dist/jquery.min.js"></script>-->
@endsection