function element(id, validations) {
	this.id = id;
	this.validations = validations;
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
		var validationsString = fieldClass.replace('validate[', '');

		var _validations = [];

		$(validationsString.split(',')).each(function(k, v) {
			_validations.push(validator._determineByString(v));
		});

		return _validations;
	},

	_determineByString: function(validationString) {
		var params;
		if (validationString.indexOf('[') > -1) {
			params = validationString.substring(validationString.indexOf('[') + 1)
			params = params.substring(0, params.indexOf(']'));

			if (params.indexOf('-') > -1) {
				// is a range
				params = params.split('-');
			}
			validationString = validationString.substring(0, validationString.indexOf('['));
		}

		switch (validationString) {
			case 'required':
				return function(value) {
					return validations.required(value);
				};
			case 'length':
				return function(value) {
					return validations.length(value, params[0], params[1]);
				};
			case 'custom':
				return function(value) {
					return validations.custom(value, params);
				}
			default:
				throw 'Not implemented validation.';
		}
	},

	create: function() {
		var validations = [];
		$("[class^='validate']").each(function(k, elem) {
			var $elem = $(elem);
			if (!validator._has($elem)) {
				return true;
			}

			validations.push(new element($elem.prop('id'), validator._generate($elem)));
		});

		return validations;
	}
};


var validations = {
	_customRegex: {
		onlyLetter:'[a-zA-Z]+',
		email: '(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$'
	},

	required: function(value) {
		return value.length > 0;
	},
	length: function(value, min, max) {
		return value.length >= min && value.length <= max;
	},
	custom: function(value, type) {
		if (!this._customRegex[type]) {
			throw 'Not implemented validation.';
		}

		var r = new RegExp('/^' + this._customRegex[type] + '/');
		return r.test(value);
	}
};