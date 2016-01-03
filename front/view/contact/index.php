<link rel="stylesheet" type="text/css" href="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_CSS', 'contact-form.css'); ?>" />

<script type="text/javascript" src="<?= $resourcesLoader->resolvePath('WEB_RESOURCE_JS', 'validator.js'); ?>"></script>

<script type="text/javascript">
	$(function() {
		var validators = validator.create();
		console.log(validators);

		$('form').on('submit', function() {
			console.log(validators.checkValidations());

			return false;
		});
	});
</script>

<div id="form-main">
	<div id="form-div">
		<form class="form" id="form1">
		  
		  <p class="name">
		    <input name="name" type="text" class="validate[required,custom[onlyLetter],length[1-100]] feedback-input" placeholder="Name" id="name" />
		  </p>
		  
		  <p class="email">
		    <input name="email" type="text" class="validate[required,custom[email]] feedback-input" id="email" placeholder="Email" />
		  </p>
		  
		  <p class="text">
		    <textarea name="text" class="validate[required,length[6-300]] feedback-input" id="comment" placeholder="Comment"></textarea>
		  </p>
		  
		  
		  <div class="submit">
		    <input type="submit" value="SEND" id="button-blue"/>
		    <div class="ease"></div>
		  </div>
		</form>
	</div>
</div>