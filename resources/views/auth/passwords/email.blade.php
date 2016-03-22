<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Recuperar contraseña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{url('img/favicon.ico')}}">
  <link rel="stylesheet" href="{{url('css/normalize.css')}}">
    <link rel="stylesheet" href="{{url('css/styles.css')}}">
  </head>
  <body class="login">
<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
	        <h1 class="tu_evaluas">Tú Evalúas</h1>
            <div class="panel panel-default">
	            <h2 class="subtitle">Recuperar Contraseña</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-sm-6 col-sm-offset-3">    
                    <form method="POST" action="{{ url('/password/email') }}">
                        {!! csrf_field() !!}
						<!-- [ THE EMAIL ] -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<p><label>Email</label>
							<input type="email" name="email" id="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </p>
                        </div>
						
                        <div class="form-group">
	                        <p><input type="submit" value="Enviar enlace para cambiar contraseña"></p>
                            
                        </div>
                    </form>
        </div>
    </div>
</div>
</body>
</html>