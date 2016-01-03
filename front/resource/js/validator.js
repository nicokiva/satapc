function validationsContainer (validations) {
	this._validations = validations;

	this.checkValidations = function() {
		if (this._validations == null || this._validations == undefined || this._validations.length == 0) {
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

	this.checkValidations = function() {
		if (this._validations == null || this._validations == undefined || this._validations.length == 0) {
			return true;
		}

		var value = $('#' + id).val();

		var result = false;
		$(this._validations).each(function(k, validation) {
			result = validation.validate(value);

			console.log(validation);
			console.log(result);
		});
	}
}

function validationContainer(validation, params) {
	this._params = params;
	this._validation = validation;

	this.validate = function(value) {
		return validations[this._validation].apply(null, [value, this._params]);
	}
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
		email: '(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))'
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