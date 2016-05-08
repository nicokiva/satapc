<link rel="stylesheet" type="text/css" href="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_CSS', 'contact-form.css'); ?>" />

<script type="text/javascript" src="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_JS', 'validator.js'); ?>"></script>

<script type="text/javascript">
	var showWe = true;

	$(function() {		
		var validations = validator.create();

		$('.whatsapp').tooltip();

		$('.we .more').on('click', function() {
			showWe = !showWe;

			if (showWe) {
				$(this).removeClass('glyphicon-triangle-bottom');
				$(this).addClass('glyphicon-triangle-top');
				$('.we').removeClass('half-collapse');
			} else {
				$(this).removeClass('glyphicon-triangle-top');
				$(this).addClass('glyphicon-triangle-bottom');
				$('.we').addClass('half-collapse');
			}
		});

		$('form').on('submit', function() {	
			validationsResult = validations.checkValidations();

			if (validationsResult) {
				var message = 
						'<h2>' +
						'	<img style="float:left; width: 100px;" src="' + "<?= $resourcesLoader->resolvePath('WEB_RESOURCE_IMG', 'icons/loading.gif'); ?>" + '" />' +
						'	<span class="popup-text">Aguarde un momento mientras enviamos su consulta...</span>' +
						'</h2>';
				showMessage(message);

				var $request = $.post(
					'contact/submit',
					$('form').serialize() 
				);

				$request.done(function(response) {
					$.unblockUI(); // closes the sending email popup

					var message = 
						'<h2>' +
							'Muchas gracias por su consulta! a la brevedad le estaremos respondiendo.' +
						'</h2>';
					showMessage(message);

					setTimeout($.unblockUI, 4000); // closes the success popup
				})
				.fail(function() {
					$.unblockUI(); // closes the sending email popup

					var message = 
						'<h2>' +
							'Ha ocurrido un error, intente nuevamente más tarde.' +
						'</h2>';

					showMessage(message);

					setTimeout($.unblockUI, 4000); // closes the error popup
				})
			}
			return false;
		});
	});


	function showMessage(message) {
		$.blockUI({ 
			message: message,
			css: {
				width: '350px'
			}
		});
	}
</script>

<div class="main">

	<div class="container">
		<div class="row">

			<div class="col-md-5 col-lg-5 box we">

				<div class="paragraph">
					<span class="title">¿Quienes somos?</span><br />
					<p class="text">
						SATAPC es una empresa surgida a principios de 2014 que nace con el objetivo de brindar soluciones tecnológicas a empresas y particulares.<br />
						
						<span class="title">Visión:</span> Ser referente en lo que a tecnología se refiere, tanto en hardware como software.<br />

						<span class="title">Misión:</span> Liderar el mercado de artículos tecnológicos del país brindándole satisfacción a los clientes a través de una asesoría dedicada y especializada, y ofreciendo una diversa gama de opciones en la búsqueda de la solución.
					</p>
				</div>

				<div class="paragraph">
					<span class="title">¿Qué hacemos?</span><br />
					<span class="text">
						Somos especialistas en:
						<ul>
							<li>Venta de smartphones y tablets</li>
							<li>Venta de computadoras y notebooks pre armadas y a medida</li>
							<li>Reparación de computadoras y notebooks</li>
							<li>Soporte técnico de software</li>
							<li>Venta de insumos</li>
							<li>Diseño y desarrollo de sitios web.</li>
							<li>Diseño y desarrollo de aplicaciones de escritorio y móviles</li>
							<li>Instalación de cámaras de seguridad</li>
							<li>Consultoría tecnológica</li>
						</ul>
					</span>
				</div>

				<div class="paragraph">
					<span class="title">¿Por qué nosotros?</span><br />
					<span class="text">
						Nos destacamos del resto del mercado en:
						<ul>
							<li>Siempre ofrecemos más de una solución</li>
							<li>Ofrecemos los mejores precios</li>
							<li>Trabajamos con las mejores marcas del mercado</li>
							<li>Brindamos un asesoramiento personal</li>
							<li>Nuestro espíritu innovador nos hace ofrecer siempre soluciones modernas y estables</li>
							<li>Nuestros productos son de la más alta calidad</li>
						</ul>
					</span>
				</div>

				<span class="more glyphicon glyphicon-triangle-top visible-xs visible-sm"></span>
			</div>

			<div class="col-md-5 col-lg-5 box">
				<form class="form">
					<p class="name">
						<input name="name" type="text" class="validate[required,custom[onlyLetter]] feedback-input" placeholder="Nombre" id="name" />
					</p>

					<p class="email">
						<input name="email" type="text" class="validate[required,custom[email]] feedback-input" id="email" placeholder="Correo Electrónico" />
					</p>

					<p class="text">
						<textarea name="text" class="validate[required,length[6-300]] feedback-input" id="comment" placeholder="Consulta"></textarea>
					</p>


					<div class="submit">
						<input type="submit" value="ENVIAR" id="button-blue"/>
						<div class="ease"></div>
					</div>
				</form>

				<span>
					O enviá un e-mail a 
					<a href="mailto:consultas@satapc.com" target="_top">consultas@satapc.com</a>
						<br />O llamá al 
						<a href="tel:+5491169220230" class="Blondie">15-6922-0230</a>
				</span>

				<br/>
				<br/>

				<div class="social">
					<a href="https://www.facebook.com/SATAPCarg" target="_blank">
						<img src="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_IMG', 'icons/facebook.png'); ?>" class="facebook" />
					</a>
					<a href="https://twitter.com/satapc" target="_blank">
						<img src="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_IMG', 'icons/twitter.png'); ?>" class="twitter" />
					</a>
					<img title="Agreganos y hacenos tu consulta al: 156-922-0230" src="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_IMG', 'icons/whatsapp.png'); ?>" class="whatsapp" />
				</div>
			</div>

		</div>
	</div>
</div>