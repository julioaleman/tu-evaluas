<!DOCTYPE html>
<html lang="es-MX">
    <head>
	    <meta charset="utf-8">
        <title><?php echo $title;?></title>
		<meta name="description" content="<?php echo $description;?>">
        <meta name="viewport" content="width=device-width">
		<link rel="shortcut icon" href="/img/favicon.ico">
		
		<link rel="stylesheet" type="text/css" href="{{url('css/normalize.css')}}">
		<link rel="stylesheet" type="text/css" href="{{url('css/styles.css')}}">

		<!-- NEW CSS -->
		<link rel="stylesheet" type="text/css" href="{{url('js/bower_components/sweetalert/dist/sweetalert.css')}}">
		<link rel="stylesheet" type="text/css" href="{{url('css/dev.css')}}">
    </head>
<body class="backend <?php echo (!isset($body_class)) ? '' : $body_class;?>">
		<!--nav-->
	    @include('layouts.nav_admin')         
	    
	    <!--content-->
        @yield('content')
			
         <!--footer-->
		@include('layouts.footer_admin')
    </body>
</html>