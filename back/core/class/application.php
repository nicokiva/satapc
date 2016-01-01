<?

	class application {
		private $_configuration;
		private $_resourcesLoader;


		public function application($configuration, $resourcesLoader) {
			$this->_configuration = $configuration;
			$this->_resourcesLoader = $resourcesLoader;
		}

		public function run($request) {
			if ($request == null) {
				throw new Exception('Invalid Request');
			}

			$controller = controller::loadController($request->getController(), $this->_resourcesLoader);
			$action = $request->getAction();


			if (!method_exists($controller, $action) || !is_callable(array($controller, $action))) {
				/* index = Index */
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