<!DOCTYPE html>
<html lang="es-MX">
    <head>
	    <meta charset="utf-8">
        <title><?php echo $title;?></title>
		<meta name="description" content="<?php echo $description;?>">
        <meta name="viewport" content="width=device-width">
		<!-- Codigo GOB.MX CSS -->
		<link href="https://framework-gb.cdn.gob.mx/favicon.ico" rel="shortcut icon">
		<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
    </head>
<body <?php echo (!isset($body_class)) ? '' : 'class="' . $body_class . '"';?>>
	<main role="main">
		<!--nav-->
	    @include('layouts.nav')         
	    
	    <div class="container vertical-buffer">
		<!--content-->
        @yield('content')
			
         <!--footer-->
		@include('layouts.footer')
	    </div>
	</main>
 </body>
</html>