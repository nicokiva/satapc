<?

	class application {
		private $_configuration;
		private $_resourcesLoader;


		public function application($configuration, $resourcesLoader) {
			$this->_configuration = $configuration;
			$this->_resourcesLoader = $resourcesLoader;
		}

		public function run($request, $external) {
			if ($request == null) {
				throw new Exception('Invalid Request');
			}

			$controller = controller::loadController($request->getController(), $this->_configuration, $this->_resourcesLoader, $external);
			if (!isset($controller) || empty($controller)) {
				// if controller not specified: /satapc/ => redirected to a default_controller taken from config
				// default action is always index
				$controller = $this->_configuration->getKey('default_controller');
				$url_prefix = $this->_configuration->getKey('url_prefix');
				header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . (!empty($url_prefix) ? $url_prefix . '/' : '') . $controller);
				exit();
			}


			$action = $request->getAction();
			if (!method_exists($controller, $action) || !is_callable(array($controller, $action))) {
				/* index = Index */
				// must return Not Found. TODO: Refactor to catch exceptions by type and response depending on a specific code.
				header('HTTP/1.0 404 Not Found');
				throw new Exception('Action not exists.');
			}

			foreach (get_class_methods($controller) as $key => $method) {
				/* for checking, methods name are case insensitive => fails when tries to execute a method with different case */
				if (strtolower($method) == strtolower($action)) {
					$action = $method;
				}
			}

			$controller->setAction($action);
			call_user_func(array($controller, $action), $request->getParams());
		}
	}

?>