<link rel="stylesheet" type="text/css" href="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_CSS', 'contact-form.css'); ?>" />

<script type="text/javascript" src="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_JS', 'validator.js'); ?>"></script>

<script type="text/javascript">
	$(function() {
		var validations = validator.create();

		$('form').on('submit', function() {	
			validationsResult = validations.checkValidations();

			if (validationsResult) {
				$.blockUI({ 
					message: 
						'<h2>' +
						'	<img style="float:left" src="' + "<?= $resourcesLoader->resolvePath('WEB_RESOURCE_IMG', 'icons/sand_watch.gif'); ?>" + '" />' +
						'	<span>Aguarde un momento mientras enviamos su consulta...</span>' +
						'</h2>',
					css: {
						width: '350px'
					}
				});

				var $request = $.post(
					'/' + siteName + '/contact/submit',
					$('form').serialize() 
				);

				$request.done(function(response) {
					$.unblockUI(); // closes the sending email popup
				})
				.fail(function(a) {
					$.unblockUI(); // closes the sending email popup


					$.blockUI({ 
						message: 'Ha ocurrido un error, intente nuevamente más tarde.'
					});

					setTimeout($.unblockUI, 2000); // closes the error popup
				})
			}
			return false;
		});
	});
</script>

<div id="form-main">
	<div id="form-div">
		<form class="form" id="form1">
		  
		  <p class="name">
		    <input name="name" type="text" class="validate[required,custom[onlyLetter]] feedback-input" placeholder="Daniel González" id="name" />
		  </p>
		  
		  <p class="email">
		    <input name="email" type="text" class="validate[required,custom[email]] feedback-input" id="email" placeholder="daniel.gonzalez@gmail.com" />
		  </p>
		  
		  <p class="text">
		    <textarea name="text" class="validate[required,length[6-300]] feedback-input" id="comment" placeholder="Solicito un presupuesto para..."></textarea>
		  </p>
		  
		  
		  <div class="submit">
		    <input type="submit" value="SEND" id="button-blue"/>
		    <div class="ease"></div>
		  </div>
		</form>
	</div>
</div>