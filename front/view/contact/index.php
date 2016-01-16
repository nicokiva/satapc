<link rel="stylesheet" type="text/css" href="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_CSS', 'contact-form.css'); ?>" />

<script type="text/javascript" src="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_JS', 'validator.js'); ?>"></script>

<script type="text/javascript">
	$(function() {
		var validations = validator.create();
		$('.services .more-services').toggle('slow');

		$('.services .more').on('click', function() {
			$('.services .more').hide();
			$('.services .more-services').toggle('fast');
		});

		$('.services .less').on('click', function() {
			$('.services .more-services').toggle('fast');
			$('.services .more').show();
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

<div id="form-main">
	<div id="form-div">
		<span class="services">
			<span class="data">
				<div class="more extra">Mostrar servicios</div>
					
				<div class="more-services"> 
					Venta de computadoras y notebooks<br />
					Reparación de computadoras y notebooks<br />
					Instalación de cámaras de seguridad<br />
					Venta de insumos<br />
					<div class="less extra">Ocultar servicios</div>
				</div>
			</span>
		</span>

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
	</div>
</div>