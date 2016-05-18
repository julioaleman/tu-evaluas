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
	    @if($body_class == "home results")   
	    <div class="video-banner" style="width: 100%; max-width: 100%; height: 470px; background: grey url('img/bannerTuEvaluas_2.png') no-repeat center center; background-size: cover; padding: 0 !important;">
			<div class="video-container" id="videoContainer" style="padding-bottom: 0;"></div>
			<div class="video-banner vplay" id="videoBannerPlay"></div>
		</div>
		@endif
	    <div class="container vertical-buffer">
		<!--content-->
        @yield('content')
			
         <!--footer-->
		@include('layouts.footer')
	    </div>
	</main>
 </body>
</html>