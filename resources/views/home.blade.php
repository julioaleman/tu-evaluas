<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="es" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title;?></title>
  <meta name="description" content="<?php echo $description;?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{url('img/favicon.ico')}}">
  <link rel="stylesheet" href="{{url('css/normalize.css')}}">
    <link rel="stylesheet" href="{{url('css/styles.css')}}">
</head>
<body <?php echo (!isset($body_class)) ? '' : 'class="' . $body_class . '"';?>>

<?php if (isset($body_class) && ($body_class == "home")):?>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
<div class="clearfix">
  <nav class="col-sm-3">
    <div class="fb">
      <?php $url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>
      <div class="fb-share-button" data-href="<?php  echo $url;?>" data-layout="button_count"></div>
    </div>
    <div class="tw">
      <a class="twitter-share-button" href="https://twitter.com/share">Tweet</a>
      <script>
window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
      </script>
    </div>
  </nav>
    <nav class="col-sm-6 col-sm-offset-3">
      <ul>
        <li><a href="{{url('que-es')}}" class="hm_link">¿Qué es?</a></li>
        <li><a href="{{url('resultados')}}" class="hm_link">Resultados</a></li>
        <li><a href="{{url('preguntas-frecuentes')}}" class="hm_link">Preguntas Frecuentes</a></li>
      </ul>
    </nav>
</div>
<?php else:?>
<header class="pg">
  <div class="clearfix">
    <nav class="col-sm-3 col-sm-offset-1">
      <a href="/" class="tuevaluas">Tú evalúas</a>
    </nav>
    <nav class="col-sm-5 col-sm-offset-3">
      <ul>
        <li <?php echo (isset($body_class) && ($body_class == "about")) ? 'class="current"' : '';?>>
          <a href="{{url('que-es')}}">¿Qué es?</a>
        </li>
        <li <?php echo (isset($body_class) && ($body_class == "data")) ? 'class="current"' : '';?>>
          <a href="{{url('resultados')}}">Resultados</a>
        </li>
        <li <?php echo (isset($body_class) && ($body_class == "faqs")) ? 'class="current"' : '';?>>
          <a href="{{url('preguntas-frecuentes')}}">Preguntas Frecuentes</a>
        </li>
      </ul>
    </nav>
  </div>  
</header> 
<div id="fb-root"></div>
  <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
<div class="clearfix">
  <div class="container">
  <div class="col-sm-5 col-sm-offset-7">
    <div class="nav_sm">
    <div class="fb">
      <?php $url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>
      <div class="fb-share-button" data-href="<?php  echo $url;?>" data-layout="button_count"></div>
    </div>
    <div class="tw">
      <a class="twitter-share-button" href="https://twitter.com/share">Tweet</a>
      <script>
window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
      </script>
    </div>
    </div>
  </div>
  </div>
</div>
<?php endif;?>




<!-- HEADER ENDS -->





<div class="container">
  <header class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <h1 class="tuevaluas">Tú Evalúas</h1>
      <h2 class="intro">Tu opinión sobre los programas públicos federales ayuda a mejorarlos.</h2>
      <p>Si recibes un correo con la invitación,<br>
        ¡<strong>participa</strong>, eres muy importante!</p>
    </div>
  </header>
  <section class="programs row">
    <div class="col-sm-10 col-sm-offset-1">
    <h2>Programas Evaluados</h2>
    </div>
    <div class="col-sm-8 col-sm-offset-2">
    <ul>
    @foreach($surveys as $survey)
      <li class="row">
        <div class="col-sm-8">
          <a href="{{url('resultados/' . $survey->id)}}">{{$survey->title}} <strong>&gt;</strong></a>
        </div>
        <div class="col-sm-4">
          <?php
            /*
            // revisa si existe el CSV
            $csv  = $survey->csv_file;
            $path = $csv ? $csv_path . $csv : false;
            $file = $path ? get_file_info($path) : false;
            $url  = $file && $file['size'] ? "/csv/{$csv}" : false;
          ?>
          <?php if($url): ?>
          <!-- si existe el CSV, muestra el link -->
          <span class="data">
            <a href="<?php echo $url; ?>">Descargar datos</a>
            </span>
          <span class="date"><?php echo date('d-m-Y h:iA', $file['date']); ?></span>
        <?php endif; ?>
        */ ?>

        </div>
      </li>
    @endforeach
    </ul>
    </div>
  </section>
</div>






<!-- FOOTER -->






<footer>
  <!-- equipo-->
  <div class="container">
    <div class="row integrantes equipo">
      <div class="col-sm-8 col-sm-offset-2">
      <h3>Equipo <strong>Tú Evalúas</strong></h3>
      <ul class="row">
        <li class="col-xs-4"><span class="presidencia">Presidencia</span></li>
        <li class="col-xs-4"><a href="http://www.presidencia.gob.mx/edn/" class="mx_digital">Estrategia Digital</a></li>
        <li class="col-xs-4"><span class="shcp">SHCP</span></li>
        <li class="col-xs-4"><a href="http://www.transparenciapresupuestaria.gob.mx/" class="transparencia">Transparencia Presupuestaria</a></li>
        <li class="col-xs-4"><a href="http://www.crea.org.mx/" class="crea">CREA A.C.</a></li>
        <li class="col-xs-4"><a href="http://gobiernofacil.com" class="gobiernofacil" title="Gobierno Fácil">Gobierno Fácil</a></li>
      </ul>
      </div>
    </div>
  </div>
  <!-- participantes-->
  <div class="integrantes participantes">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <h3>Participantes <strong>Tú Evalúas</strong></h3>
          <ul class="row">
            <li class="col-xs-2"></li>
            <li class="col-xs-4"><a href="http://www.vas.gob.mx/swb/swb/PORTALVAS/home" class="prospera">Sedesol Prospera</a></li>
            <li class="col-xs-4"><a href="https://www.inadem.gob.mx/" class="inadem">INADEM</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  <div class="links_bottom">
    <div class="container">
      <div class="row">
      <div class="col-sm-3">
        <p><span class="tu_evaluas">Tú Evalúas</span> ©2015</p>
      </div>
      <div class="col-sm-9">
        <ul>
          <li><a href="{{url('que-es')}}">¿Qué es?</a></li>
          <li><a href="{{url('resultados')}}">¿Qué es?</a></li>  
          <li><a href="{{url('preguntas-frecuentes')}}">¿Qué es?</a></li>  
          <li><a href="{{url('terminos')}}">¿Qué es?</a></li>  
          <li><a href="{{url('privacidad')}}">¿Qué es?</a></li>  
          <li><a href="{{url('contacto')}}">¿Qué es?</a></li>      
        </ul>
      </div>
    </div>
    </div>
  </div>
</footer>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45473222-7', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>