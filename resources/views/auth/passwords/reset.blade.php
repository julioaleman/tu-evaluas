<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cambiar contraseña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{url('img/favicon.ico')}}">
  <link rel="stylesheet" href="{{url('css/normalize.css')}}">
    <link rel="stylesheet" href="{{url('css/styles.css')}}">
  </head>
  <body class="login">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
	        <h1 class="tu_evaluas">Tú Evalúas</h1>
	        <h2 class="subtitle">Cambiar Contraseña</h2>
		</div>        
		<div class="col-sm-6 col-sm-offset-3">    
			<form method="POST" action="{{ url('/password/reset') }}">
        	    {!! csrf_field() !!}
        	    <input type="hidden" name="token" value="{{ $token }}">
			
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
			
        	    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	        	    <p><label>Contraseña</label>
        	        	 <input type="password" name="password">
			
        	            @if ($errors->has('password'))
        	                <span class="help-block">
        	                    <strong>{{ $errors->first('password') }}</strong>
        	                </span>
        	            @endif
	        	    </p>
        	    </div>
			
        	    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	        	    <p><label>Confirmar Contraseña</label>
        	        	 <input type="password" name="password_confirmation">
			
        	            @if ($errors->has('password_confirmation'))
        	                <span class="help-block">
        	                    <strong>{{ $errors->first('password_confirmation') }}</strong>
        	                </span>
        	            @endif
	        	    </p>
        	        
        	    </div>
				<div class="form-group">
	                <p><input type="submit" value="Cambiar contraseña"></p>
                </div>
        	   
        	</form>
        </div>
    </div>
</div>
</body>
</html>
