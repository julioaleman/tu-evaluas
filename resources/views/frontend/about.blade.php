@extends('layouts.master')

@section('content')
<!--breadcrumb-->
<div class="row">
	<div class="col-sm-8">
	  <ol class="breadcrumb">
	    <li><a href="https://www.gob.mx"><i class="icon icon-home"></i></a></li>
	    <li><a href="{{ url('')}}">Tú Evalúas</a></li>
        <li class="active">¿Qué es?</li>
	  </ol>
	</div>
</div>
				<div class="bottom-buffer">
						<div class="row">
							<div class="col-md-8">
							<h2>¿Qué es <strong>Tú Evalúas</strong>?</h2>
								<hr class="red">
                                <p><strong>Tú Evalúas</strong> es una plataforma digital que <strong>tiene como objetivo evaluar el desempeño</strong> de los programas públicos 
                                  federales mediante la participación ciudadana. A través de <strong>Tú Evalúas</strong> podrás calificar los procesos seguidos 
                                  por cada programa y expresar tu 
                                  satisfacción con los productos y servicios que ofrecen.</p>
                                <p><strong>Tú Evalúas</strong> facilitará la colaboración entre el gobierno y la ciudadanía partiendo de una base 
                                  tecnológica para:</p>
                                <ol>
                                  <li>Conocer la opinión ciudadana sobre la operación de los programas.</li>
                                  <li>Mejorar la evaluación de los programas con base en las necesidades expresadas directamente por la ciudadanía.</li>
                                  <li>Generar espacios de aprendizaje que conduzcan a mejores políticas públicas.</li>
                                </ol>
                                <p>La meta es que <strong>Tú Evalúas</strong> reúna toda la información referente a la satisfacción de la ciudadanía 
                                  con respecto a los programas públicos federales para que quien lo desee (ciudadanos, 
                                  asociaciones, gobierno o la comunidad en conjunto) pueda dar seguimiento al pulso ciudadano.
                                </p>
                                <hr>
							</div>
						</div>
				</div>
                
                <div class="bottom-buffer">
						<div class="row">
							<div class="col-md-8">
								<h2>Nosotros</h2>
								<hr class="red">
                                <p>Esta iniciativa nace como parte del proyecto <a href="http://www.presidencia.gob.mx/agentesdeinnovacion/">Agentes de Innovación</a> 
                                  de la <a href="http://www.presidencia.gob.mx/edn/">Coordinación de la Estrategia Digital Nacional de 
                                  la Presidencia de la República</a>, cuyos objetivos son impulsar el gobierno digital, promover la apertura, la transparencia 
                                  y la participación ciudadana mediante el uso de las  tecnologías de la información y la comunicación (TIC). </p>
                                
                                <p>Así, <strong>Tú Evalúas</strong> nace de la cooperación entre la Presidencia de la República a través de la Coordinación de Estrategia 
                                  Digital Nacional, la <a href="http://www.transparenciapresupuestaria.gob.mx/">Secretaría de Hacienda y Crédito Público a 
                                    través de la Unidad de Evaluación del Desempeño</a>, 
                                  <a href="http://www.crea.org.mx/">CREA, A.C.</a>  y 
                                  <a href="http://gobiernofacil.com/" title="Gobierno Fácil">Gobierno Fácil</a>. 
                                </p>
                                <p><strong>Tú Evalúas</strong> busca consolidarse como una herramienta para que los ciudadanos participen de la configuración 
                                  de los objetivos y 
                                  las políticas públicas de las dependencias del gobierno federal. Mediante la aplicación de cuestionarios a beneficiarios y no beneficiarios de los programas públicos federales y la publicidad de las encuestas de satisfacción, será posible medir el desempeño de los programas desde una perspectiva ciudadana, así como dar a conocer esa perspectiva a los tomadores de decisiones y al público en general.
                                </p>
                                <hr>
							</div>
						</div>
				</div>
<!-- equipo-->
<div class="row">
	<div class="col-md-12">		
		<h2>Equipo</h2>
		<hr class="red">
		<div class="row">
		   <p class="col-xs-4"><a href="http://www.gob.mx/presidencia/"><img src="{{ url('img/presidencia_.png') }}"  alt="Presidencia de la República"></a></p>
	        <p class="col-xs-4"><a href="http://www.transparenciapresupuestaria.gob.mx"><img src="{{ url('img/transparencia_presupuestaria_.png') }}" alt="Transparencia Presupuestaria"></a></p>
		   <p class="col-xs-4"><a href="http://www.gob.mx/hacienda"><img src="{{ url('img/shcp_.png') }}" alt="Secretaría de Hacienda y Crédito Público"></a></p>
		</div>
		<div class="row">
		   <p class="col-xs-4 col-xs-offset-2"><a href="http://www.crea.org.mx"><img src="{{ url('img/crea_emp_.png') }}" alt="CREA. Comunidad de Emprendedores Sociales"></a></p>
		   <p class="col-xs-4"><a href="http://www.gobiernofacil.com"><img src="{{ url('img/gobierno_facil_.png') }}" alt="Gobierno Fácil"></a></p>
		</div>
	</div>
</div>

<!-- participantes-->
<div class="row">
	<div class="col-md-12">
		<h2>Participantes</h2>
		<hr class="red">
		<div class="row">
			<p class="col-xs-4"><a href="http://www.prospera.gob.mx"><img src="{{ url('img/sedesol_.png') }}"  alt="SEDESOL"></a></p>
            <p class="col-xs-4"><a href="http://www.prospera.gob.mx"><img src="{{ url('img/prospera_.png') }}" alt="PROSPERA"></a></p>
			<p class="col-xs-4"><a href="http://www.inadem.gob.mx"><img src="{{ url('img/inadem_.png') }}" alt="Inadem"></a></p>
		</div>
		<div class="row">
		   <p class="col-xs-4 col-xs-offset-2"><a href="http://www.imjuventud.gob.mx/"><img src="{{ url('img/imjuve_.png') }}" alt="IMJUVE"></a></p>
		   <p class="col-xs-4"><a href="http://www.conacyt.mx/"><img src="{{ url('img/conacyt_.png') }}" alt="CONACYT"></a></p>
		</div>
	</div>
</div>
@endsection