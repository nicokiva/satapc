<?

	abstract class controller {
		private $_controllerName;
		private $_currentAction;

		static function loadController ($controller) {
			if (!isset($controller) || empty($controller)) {
				throw new Exception("Controller is missing");
			}

			$file = '../controller/' . $controller . '.php';
			// glob return all files with specific pattern
			foreach (glob("../controller/*.php") as $filename) {
				if (strtolower($filename) == strtolower($file)) {
			    	include $filename;

			    	$controller .= 'Controller';
			    	return new $controller();
			    }
			}
		}

		public function controller () {
			// get each controller's name
			$this->_controllerName = str_replace('controller', '', strtolower(get_class($this)));
		}

		public function setAction($action) {
			$this->_currentAction = $action;
		}

	 	public function showView($view = null, $data = null) {
	 		if (!isset($view) || empty($view)) {
	 			$view = $this->_currentAction;
	 		}

	 		$file = '../../front/view/' . $this->_controllerName .'/' . $view . '.php';
	 		if (!file_exists($file)) {
	 			throw new Exception('View not exists.');
	 		}

	 		include($file);
	 	}

	}

?>