<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="es" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{$blueprint->title}} | Tú Evalúas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Codigo GOB.MX CSS -->
    <link href="https://framework-gb.cdn.gob.mx/favicon.ico" rel="shortcut icon">
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
</head>
<body>
<main role="main">
<!--nav-->
<?php /* @include('layouts.nav') */ ?>

<div class="container bottom-buffer">
<!--breadcrumb-->
<div class="row">
	<div class="col-sm-8">
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="icon icon-home"></i></a></li>
	    <li><a href="https://www.gob.mx">Inicio</a></li>
	    <li><a href="{{ url('')}}">Tú Evalúas</a></li>
        <li class="active">Encuesta:  {{$blueprint->title}}</li>
	  </ol>
	</div>
</div>


<div class="row">
	<div class="col-md-12 bottom-buffer">
		<!--egb_div class="contenedor vertical-buffer"-->
			<image src="{{url('img/logov0_.png')}}"></image>
		<!--egb_/div-->
	</div>
</div>
<div class="row bottom-buffer">
	<div class="col-md-8">
		<h1>{{$blueprint->title}}</h1>
		<hr class="red">
	</div>
</div>
<div class="bottom-buffer">
    @if($is_admin && !$blueprint->is_visible)
    <div class="alert alert-danger">
      <p class="warning">La encuesta está oculta, pero al ser un usuario registrado, puedes verla :D</p>
    </div>
    @endif
</div>
<div class="bottom-buffer">
    <div id="main" class="row">
		<div class="col-md-8">
    	  <form id="survey" role="form">
    	  	{!! csrf_field() !!}
    	  	<p id="annoying-message" style="display: none">Debes contestar las preguntas para avanzar a la siguiente sección ;D 
		  	    <a href="#" class="close-me">x</a></p>
    	  </form>
    	</div>
    </div>
</div>
  
<!--footer-->
@include('layouts.footer')
</div>
</main>
<!-- JS STUFF -->
  <script>
  var agentesFormSettings = {
        key       : "{{$applicant->form_key}}",
        title     : "{{$blueprint->title}}",
        id        : {{$blueprint->id}},
        is_test   : false,//{{$is_test}},
        questions : <?php echo json_encode($questions); ?>,
        options   : <?php echo json_encode($options); ?>,
        rules     : <?php echo json_encode($rules); ?>,
        answers   : <?php echo json_encode($answers); ?>
      };

      // Hack pitero para tener un mensaje de agradecimiento al final del questionario
      agentesFormSettings.questions.push({
        blueprint_id   : '1',
        creation_date  : '2015-02-23 12:14:59',
        default_value  : null,
        id             : '666666',
        question       : '<p>gracias por participar en este estudio</p>',
        is_description : '1',
        order_num      : '1',
        section_id     : '666',
        type           : 'text'
      });
  </script>
<!-- DEVELOPMENT SOURCE -->
<script src="{{url('js/bower_components/requirejs/require.js')}}"></script>
<script src="{{url('js/main-built.js')}}"></script>
<!--<script data-main="{{url('js/main')}}" src="{{url('js/bower_components/requirejs/require.js')}}"></script>-->
</body>
</html>