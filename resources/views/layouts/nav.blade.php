@if (isset($body_class) && ($body_class == "home"))
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
				<li><a href="{{url('que-es')}}" class="hm_link">¿Qué es?</a>
				<li><a href="{{url('resultados')}}" class="hm_link">Resultados</a>
				<li><a href="{{url('preguntas-frecuentes')}}" class="hm_link">Preguntas Frecuentes</a>				
			</ul>
		</nav>
</div>
@else
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
@endif