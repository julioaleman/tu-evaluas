<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
	<title>Cambia tu contraseña para Tú Evalúas</title>
</head>

<body>
<!-- saludo -->
<h1 style="font-family: 'Open Sans Light', Helvetica, Arial, sans-serif ;color:#545454; font-size:38px; line-height:1.428; text-align:left; padding-top: 25px; padding-bottom: 2.5px;">Hola, da clic en el siguiente link para cambiar tu contraseña</h1> 
<hr style="border-top: 1px solid #DDDDDD; border-bottom:none; border-left: 1px solid #D0021B;; border-right:none; height: 6px; border-left-width: 35px"> 
<p style="font-family: 'Open Sans Light', Helvetica, Arial, sans-serif;color:#545454; font-size:16px; line-height:1.428; text-align:justify"> 
<a href="{{ url('password/' . $pass_key) }}" style="color:#12C">Recuperar contraseña</a> </p> 

<p style="font-family: 'Open Sans Light', Helvetica, Arial, sans-serif ;color:#545454; font-size:16px; line-height:1.428; text-align:justify"> Este link será válido durante 3 días. </p>

</body>
</html>

