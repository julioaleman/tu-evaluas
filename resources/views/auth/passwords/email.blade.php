<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Recuperar contraseña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width"> 
    <!-- Codigo GOB.MX CSS --> <link href="https://framework-gb.cdn.gob.mx/favicon.ico" rel="shortcut icon"> 
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet"> 
  </head>
  <body class="login">
<!-- Main Content -->
<main role="main"> 
	<div class="video-banner" style="width: 100%; max-width: 100%; height: 300px; background: grey url('/img/bannerTuEvaluas_2.png') no-repeat center center; background-size: cover; padding: 0 !important;"> 
	</div> 
	<div class="container vertical-buffer"> 
		<div class="row"> 
			<div class="col-md-8"> 
				<h2>Recuperar contraseña</h2> 
			</div> 
		</div> 
<div class="container">
    <div class="row">
        <div class="col-md-8">
                    @if (session('status'))
            <div class="panel panel-default">
                <div class="panel-body">
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                </div>
            </div>
                    @endif
        </div>
        
        <div class="col-md-8">  
             <form method="POST" action="{{ url('/password/email') }}" class="form-horizontal" role="form">
                 {!! csrf_field() !!}
			  <!-- [ THE EMAIL ] -->
                 <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}"> 
					<label class="col-sm-3 control-label" for="email">Email:</label>
					<div class="col-sm-9"> 
						<input class="form-control" name="email" id="email" placeholder="Correo electrónico"  value="{{ old('email') }}" type="email" required> 
						<div class="help-block with-errors">
							@if ($errors->has('email'))
                             <span class="help-block">
                                 <strong>{{ $errors->first('email') }}</strong>
                             </span>
                         @endif
						</div> 
					</div> 
				</div>
			  <!-- [ THE EMAIL ] -->
               
			  	<div class="form-group"> 
					<div class="col-sm-offset-3 col-sm-9">
						<button class="btn btn-primary pull-right" type="submit">Enviar enlace para cambiar contraseña</button> 
					</div> 
				</div> 
				
             </form>
        </div>
    </div>
</div>
</main> 
<!--footer--> 
<!-- JS --> 
<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script> 
</body>
</html>