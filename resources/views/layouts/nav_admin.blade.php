<header class="pg">
  <div class="clearfix">
    <nav class="col-sm-3 col-sm-offset-1">
      <a href="{{url('/')}}" class="tuevaluas">Tú evalúas</a>
    </nav>
    <nav class="col-sm-1 col-sm-offset-7">
      <ul>
        <li><a href="{{url('logout')}}">Salir</a></li>
      </ul>
    </nav>
  </div>  
</header> 
<nav class="nav_back">
  <div class="container">
    <div class="row">
        <ul>
        <li class="{{$body_class == 'dash' ? 'current' : ''}}">
          <a href="{{url('dashboard')}}">Dashboard</a>
        </li>

          <li class="{{$body_class == 'surveys' ? 'current' : ''}}">
            <a href="{{url('dashboard/encuestas')}}">{{$user->level == 3 ? "Todas las Encuestas" : "Mis encuestas"}}</a>
          </li>

          <li class="{{$body_class == 'users' ? 'current' : ''}}">
            @if($user->level == 3)
            <a href="{{url('dashboard/usuarios')}}">Usuarios</a>
            @else
            <a href="{{url('dashboard/usuarios')}}">Cuenta</a>
            @endif
          </li>
          @if($user->level == 3)
          <li class="{{$body_class == 'authorizations' ? 'current' : ''}}">
            <a href="{{url('dashboard/autorizaciones')}}">Autorizaciones</a>
          </li> 
          @endif

          <li class="{{$body_class == 'applicants' ? 'current' : ''}}">
          <a href="{{url('dashboard/encuestados')}}">Enviar encuestas</a>
        </li>
         <!--
         <li><a href="{{url('dashboard/datos')}}">Datos abiertos</a></li>
          <li><a href="{{url('dashboard/correos')}}">Correos</a></li>-->
        </ul>
    </div>
  </div>
</nav>

<!-- ERROR / SUCCESS MESSAGE -->
<?php /*
<?php $m = $this->session->flashdata('sys_message'); if($m): ?>
  <div class="<?php echo $m["type"]; ?>"><?php echo $m["message"]; ?></div>
<?php endif; ?>
*/ ?>
<!-- HEADER TEMPLATE ENDS -->