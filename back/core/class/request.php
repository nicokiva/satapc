<?
	class request {
		private $_controller;
		private $_action;
		private $_params;

		function getController() {
			return $this->_controller;
		}

		function getAction() {
			return $this->_action;
		}

		function getParams() {
			return $this->_params;
		}
		

		function request ($controller, $action, $params) {
			if (!isset($controller) || empty($controller)) {
				throw new Exception("Missing Controller");
			}

			if (!isset($action) || empty($action)) {
				throw new Exception("Missing Action");
			}

			$this->_controller = $controller;
			$this->_action = $action;

			if ($params != null && count($params) > 0) {
				$this->_params = array();

				foreach ($params as $key => $value) {
					$this->_params[$key] = new param($key, $value);
				}
			}
		}
	}

	class param {
		private $_name;
		private $_value;

		function param ($key, $value) {
			if (!isset($key) || empty($key)) {
				throw new Exception("Missing Key");
			}

			if (!isset($value) || empty($value)) {
				throw new Exception("Missing Value");
			}

			$this->_name = $key;
			$this->_value = $value;
		}

		public function getValue() {
			return $this->_value;
		}
	}


?>