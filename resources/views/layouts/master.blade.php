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
		<!--nav-->
	    @include('layouts.nav')         
	    
	    <!--content-->
        @yield('content')
			
         <!--footer-->
		@include('layouts.footer')
    </body>
</html>