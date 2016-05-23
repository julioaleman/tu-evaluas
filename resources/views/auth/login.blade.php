<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Pase usted</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width"> 
    <!-- Codigo GOB.MX CSS --> <link href="https://framework-gb.cdn.gob.mx/favicon.ico" rel="shortcut icon"> 
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet"> 
    
  </head>
  <body class="login">
<main role="main"> <!--content--> 
	  <div class="video-banner" style="width: 100%; max-width: 100%; height: 300px; background: grey url('/img/bannerTuEvaluas_2.png') no-repeat center center; background-size: cover; padding: 0 !important;"> 
	</div> 
	
<div class="container vertical-buffer"> 
	<div class="col-md-8"> 
		<div class="row"> 
				<h2>Iniciar sesión</h2> 
		</div>
	</div> 
	<div class="row">
		<div class="col-md-8"> 
          <form name="nock-nock" method="post" action="{{ url('/login') }}" class="form-horizontal" role="form">
          {!! csrf_field() !!}
            <!-- [ ERROR MESSAGE ] 
            <?php /*
            <?php if(isset($errors['email']) && $errors['email']): ?>
            <p>El usuario y la contraseña no coinciden</p>
            <?php elseif(isset($errors['email']) && ! $errors['email']): ?>
            <p>El correo no es válido :/</p>
            <?php endif; ?>
            */ ?>
            -->
			<div class="form-group"> 
				<label class="col-sm-3 control-label" for="email">Email:</label> 
				<div class="col-sm-9"> 
					<input type="email"  name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}" required> 
				</div> 
			</div>
			<div class="form-group"> 
					<label class="col-sm-3 control-label" for="password">Contraseña:</label> 
					<div class="col-sm-9"> 
            <!-- [ THE PASSWORD ] -->
						<input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required> <br>
						<a href="{{url('password/reset')}}">Recuperar contraseña</a> 
					</div> 
				</div> 
				<div class="form-group"> 
					<div class="col-sm-offset-3 col-sm-9"> 
						<button class="btn btn-primary pull-right" type="submit">Iniciar sesión</button> 
					</div> 
				</div> 
          </form>
        </div>
      </div>
    </div>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45473222-7', 'auto');
  ga('send', 'pageview');

</script>
<script>
  // [ CRAPY VALIDATION ]
  var form = document.getElementsByTagName('form')[0];

  form.onsubmit = function(e){
    e.preventDefault();
    var email = document.getElementById('email'),
        pass  = document.getElementById('password');

    email.className = '';
    pass.className = '';

    if(! email.value){
      email.className += ' ' + 'error'; 
      return;
    }
    if(! pass.value){
      pass.className += ' ' + 'error'; 
      return;
    } 
   
    this.submit();
  }
</script>
</main> 
<!--footer--> 
<!-- JS --> 
<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script> 
</body> 
</html> 