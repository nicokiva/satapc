<link rel="stylesheet" type="text/css" href="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_CSS', 'contact-form.css'); ?>" />

<script type="text/javascript" src="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_JS', 'validator.js'); ?>"></script>

<script type="text/javascript">
	$(function() {
		var validations = validator.create();

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
				.fail(function(a) {
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

<div class="form-main">

	<div class="container">
		<div class="row">

			<div class="col-md-5 col-lg-5 box">
				Venta de computadoras y notebooks<br />
				Reparación de computadoras y notebooks<br />
				Instalación de cámaras de seguridad<br />
				Venta de insumos<br />
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
				</div>
			</div>

		</div>
	</div>
		

<!--
	<div id="form-div">
		

		
	</div>
-->
</div>