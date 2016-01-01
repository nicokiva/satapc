<?

	abstract class controller {
		private $_controllerName;
		private $_currentAction;
		private $_resourcesLoader;

		private $_defaultOptions = array(
			'includeHeader' => true,
			'includeFooter' => true
		);

		static function loadController ($controller, $resourcesLoader) {
			if (!isset($controller) || empty($controller)) {
				throw new Exception("Controller is missing");
			}

			$file = '../controller/' . $controller . '.php';
			// glob return all files with specific pattern
			foreach (glob("../controller/*.php") as $filename) {
				if (strtolower($filename) == strtolower($file)) {
			    	include $filename;

			    	$controller .= 'Controller';
			    	return new $controller($resourcesLoader);
			    }
			}
		}

		public function controller ($resourcesLoader) {
			$this->_controllerName = str_replace('controller', '', strtolower(get_class($this))); // get each controller's name
			$this->_resourcesLoader = $resourcesLoader;
		}

		public function setAction($action) {
			$this->_currentAction = $action;
		}

	 	public function showView($view = null, $data = null, $options = null) {
	 		if (!isset($view) || empty($view)) {
	 			$view = $this->_currentAction;
	 		}


	 		$displayOptions = $this->_defaultOptions;
	 		if ($options != null && count($options) > 0) {
	 			$displayOptions = array_merge($displayOptions, $options);
	 		} 

	 		if (array_key_exists('includeHeader', $displayOptions) && $displayOptions['includeHeader'] == true) {
	 			$this->showHeader();
	 		}

	 		$this->show('../../front/view/' . $this->_controllerName .'/' . $view . '.php');

	 		if (array_key_exists('includeFooter', $displayOptions) && $displayOptions['includeFooter'] == true) {
	 			$this->showFooter();
	 		}
	 	}

	 	private function showHeader() {
	 		$this->show('../../front/view/general/header.php');
	 	}

	 	private function showFooter() {
	 		$this->show('../../front/view/general/footer.php');
	 	}

	 	private function show($file) {
	 		if (!file_exists($file)) {
	 			throw new Exception('View: ' . $file . ' not exists.');
	 		}

	 		$resourcesLoader = $this->_resourcesLoader;
	 		include($file);
	 	}

	}

?>