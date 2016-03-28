<!DOCTYPE html>
<html lang="es-MX">
    <head>
	    <meta charset="utf-8">
        <title><?php echo $title;?></title>
		<meta name="description" content="<?php echo $description;?>">
        <meta name="viewport" content="width=device-width">
		<link rel="shortcut icon" href="/img/favicon.ico">
		<link rel="stylesheet" type="text/css"  href="/css/normalize.css">
		<link rel="stylesheet" type="text/css" href="/css/styles.css"/>
    <link rel="stylesheet" type="text/css" href="/css/alice.css"/>
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