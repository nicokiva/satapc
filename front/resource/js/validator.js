var errorTypes = {
	REQUIRED: 'REQUIRED',
	LENGTH: 'LENGTH',
	CUSTOM: 'CUSTOM',

	messages: {
		REQUIRED: 'El campo no puede estar vacío.',
		LENGTH: 'El campo debe cumplir la cantidad de caracteres específica.',
		CUSTOM: 'El campo no cumple las especificaciones necesarias.'
	}
};


function validationsContainer (validations) {
	this._validations = validations;

	this.checkValidations = function() {
		$('.error').removeClass('error');
		$('.error-description').remove();

		if (!this._validations || this._validations.length == 0) {
			return true;
		}

		var result = false;
		$(this._validations).each(function(k, element) {
			result = element.checkValidations();
		});
	}
}

function elementContainer(id, validations) {
	this._id = id;
	this._validations = validations;
	this._errors;

	this.showError = function() {
		var $elem = $('#' + id);
		
		var $container = $elem.parent();

		var errorText = '';
		$(this._errors).each(function(k, e) {
			errorText += errorTypes.messages[e] + '<br />';
		});

		var $errorLabel = $('<label></label>')
							.addClass('error-description')
							.html(errorText);
		$elem.before($errorLabel);
		$elem.addClass('error');
	};

	this.checkValidations = function() {
		if (!this._validations || this._validations.length == 0) {
			return true;
		}
		this._errors = [];

		var errorType;
		var $elem = $('#' + id);
		var value = $elem.val();
		var result = false;

		var self = this;
		$(this._validations).each(function(k, validation) {
			result = validation.validate(value);

			if (!result) {
				errorType = validation.getValidation().toUpperCase();
				self._errors.push(errorTypes[errorType]);
			}
		});

		if (this._errors.length > 0) {
			this.showError();
		}
	};
}

function validationContainer(validation, params) {
	this._params = params;
	this._validation = validation;

	this.getValidation = function () {
		return this._validation;
	};

	this.validate = function(value) {
		return validations[this._validation].apply(null, [value, this._params]);
	};
}


var validator = {
	_has: function($field) {
		return $field != null && $field.prop('class').match(/^validate\[(.*)\]/gm);
	},

	_generate: function($field) {
		if (!this._has($field)) {
			return [];
		}

		/* must get only the validations part and discard the rest */
		var fieldClass = $field.prop('class').match(/^validate\[(.*)\]/gm)[0];
		fieldClass = fieldClass.substring(0, fieldClass.length -1); // removes the last ]
		var validationName = fieldClass.replace('validate[', '');

		var _validations = [];

		$(validationName.split(',')).each(function(k, v) {
			_validations.push(validator._determineByString(v));
		});

		return _validations;
	},

	_determineByString: function(validationString) {
		var params = [];
		var validationName = validationString;
		if (validationString.indexOf('[') > -1) {
			paramsString = validationString.substring(validationString.indexOf('[') + 1)
			paramsString = paramsString.substring(0, paramsString.indexOf(']'));

			if (paramsString.indexOf('-') > -1) {
				// is a range
				params = paramsString.split('-');
			} else {
				params.push(paramsString);
			}
			validationName = validationString.substring(0, validationString.indexOf('['));
		}

		if (validations[validationName] == undefined) {
			throw 'Not implemented validation.';
		}

		return new validationContainer(
			validationName,
			params
		);
	},

	create: function() {
		var validations = [];
		$("[class^='validate']").each(function(k, elem) {
			var $elem = $(elem);
			if (!validator._has($elem)) {
				return true;
			}

			validations.push(new elementContainer($elem.prop('id'), validator._generate($elem)));
		});

		return new validationsContainer(validations);
	}
};

/* available validations */
var validations = {
	_customRegex: {
		onlyLetter:'[a-zA-Z]+',
		email: '(([A-Za-z0-9_])+)[@](([A-Za-z0-9_])+)[.](([A-Za-z]){2,3})([.](([A-Za-z]){2}))?'
	},

	required: function(value) {
		return value.length > 0;
	},
	length: function(value, threshold) {
		var min = threshold[0];
		var max = threshold[1];
		return value.length >= min && value.length <= max;
	},
	custom: function(value, type) {
		if (!validations._customRegex[type]) {
			throw 'Not implemented validation.';
		}

		var r = new RegExp(validations._customRegex[type] + '$');
		return r.test(value);
	}
};