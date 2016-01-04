<link rel="stylesheet" type="text/css" href="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_CSS', 'contact-form.css'); ?>" />

<script type="text/javascript" src="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_JS', 'validator.js'); ?>"></script>

<script type="text/javascript">
	$(function() {
		var validations = validator.create();

		$('form').on('submit', function() {	
			validations.checkValidations();

			console.log(validations);

			console.log();
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