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
<!--nav-->
@include('layouts.nav') 

<hr>
<div class="container cuestiona">
    <h1 align="center">{{$blueprint->title}}</h1>
    <hr class="red">
    @if($is_admin && !$blueprint->is_visible)
      <p class="warning">La encuesta está oculta, pero al ser un usuario registrado, puedes verla :D</p>
    @endif

    <div id="main" class="row">
    	<div class="col-sm-10 col-sm-offset-1">
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
<script data-main="{{url('js/main')}}" src="{{url('js/bower_components/requirejs/require.js')}}"></script>
</body>
</html>