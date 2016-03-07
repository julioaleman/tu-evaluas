@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<article>
		<div class="col-sm-8 col-sm-offset-2">
			<h1>Envía un mensaje a la plataforma <strong>Tú Evalúas</strong></h1>
			<form class="contact_form">
				<p><label for="name">Nombre</label></p>
				<p><input type="text" name="name"></p>
				<p><label for="email">Email</label></p>
				<p><input type="email" name="email"></p>
				<p><label for="message">Mensaje</label></p>
				<p><textarea name='message'></textarea></p>
				
				<p><input type="submit" value="Enviar Mensaje"></p>
			</form>			
		</div>
		</article>
	</div>
</div>
@endsection