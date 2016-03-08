@extends('layouts.master_admin')

@section('content')
<div class="container dashboard">
  <div class="row">
    <div class="col-md-12">
      <h1 class="title">Dashboard</h1>
    </div>
    <div class="col-sm-4 col-sm-offset-2 box">
      <h3><a href="{{url('dashboard/encuestas')}}"><strong>{{$surveys->count()}}</strong> 
        {{$surveys->count() == 1 ? 'Encuesta' :'Encuestas'}} &gt;</a></a>
      </h3>
      <p> <a href="{{url('dashboard/encuestas')}}">Crear Encuesta</a></p>
    </div>
    @if($user->level == 3)
    <div class="col-sm-4 col-sm-offset-1 box">
      <h3><a href="{{url('dashboard/usuarios')}}"><strong>{{$admins->count()}}</strong> 
        {{ $admins->count() == 1 ? 'Usuario' :'Usuarios'}} &gt;</a>
      </h3>
      <p> <a href="{{url('dashboard/usuarios')}}">Crear Usuario</a></p>
    </div>
    @endif
  </div>
  </div>
</div>
@endsection