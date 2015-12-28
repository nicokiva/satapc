<?

	abstract class controller {
		private $_controllerName;

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

	 	public function showView() {
	 		echo $_controllerName;
	 	}

	}



?>