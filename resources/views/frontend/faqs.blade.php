@extends('layouts.master')

@section('content')
<!--breadcrumb-->
<div class="row">
	<div class="col-sm-8">
	  <ol class="breadcrumb">
	    <li><a href="https://www.gob.mx"><i class="icon icon-home"></i></a></li>
	    <li><a href="{{ url('')}}">Tú Evalúas</a></li>
        <li class="active">Preguntas Frecuentes</li>
	  </ol>
	</div>
</div>
				<div class="bottom-buffer">
						<div class="row">
							<div class="col-md-8">
								<h2>Preguntas Frecuentes</h2>
                                <hr class="red">
                                <h3>¿Cómo van a usar mis respuestas?</h3>
                                <p>El portal tiene por objetivo recabar la opinión ciudadana sobre los programas públicos federales. Los resultados de los cuestionarios serán de carácter público en tiempo real y en bases de datos en formato abierto. </p>
                                <p>Los resultados serán un insumo para medir la calidad de los programas desde la perspectiva ciudadana y acercar esa perspectiva tanto a los ejecutores de los programas en las dependencias federales  como al público en general.</p>
                                <hr>
                                <h3>¿Cómo fueron obtenidos mis datos de contacto para invitarme a participar en una encuesta?</h3>
                                <p>El portal <strong>Tú Evalúas</strong> es una iniciativa del gobierno federal y la información utilizada fue recabada por cada programa en apego al Título IV de la Ley Federal de Transparencia y Acceso a la Información, referente a la protección de datos personales. </p>
                                <hr>
                                <h3>¿Cómo puedo participar en una encuesta?</h3>
                                <p>A través de <strong>Tú Evalúas</strong>, los ejecutores de cada programa envían invitaciones a los beneficiarios de los programas y/o a solicitantes que registraron sus datos a través de los sistemas asociados a cada programa. </p>
                                <hr>
                                <h3>Al responder los cuestionarios del portal Tú Evalúas ¿existe algún riesgo de perder el apoyo o subsidio con el que cuento?</h3>
                                <p><strong>NO.</strong> Las opiniones recabadas en el sitio <strong>Tuevaluas.com.mx</strong> no pueden asociarse con la persona que las emite, 
                                    por lo que de ninguna manera pueden ser utilizadas para condicionar los apoyos o subsidios gubernamentales. </p>
                                <hr>
                                <h3>¿Qué significa que mis respuestas a los cuestionarios serán utilizadas como datos abiertos?</h3>
                                <p>Que las respuestas a los cuestionarios se concentrarán en un formal xls o csv (bases de datos agregadas) y serán de dominio público en un formato accesible para su uso, reutilización y redistribución para cualquier fin legal que se desee. </p>
                                <hr>
                                <h3>¿Cómo se garantiza la veracidad de la información del portal Tú Evalúas?</h3>
                                <p>Los resultados de las encuestas que se realizan en el portal <strong>Tú Evalúas</strong> son cargados en el sistema y publicados en tiempo real, lo que implica que no hay ninguna organización pública o privada que previamente valide o modifique la información que se despliega. </p>
                                <hr>
							</div>
						</div>
				</div>
@endsection