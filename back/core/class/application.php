<?

	class application {
		private $_configuration;
		private $_resourcesLoader;
		private $_response;


		public function __construct($configuration, $resourcesLoader) {
			$this->_configuration = $configuration;
			$this->_resourcesLoader = $resourcesLoader;
			$this->_response = new response();
		}

		public function run($request, $external) {
			if ($request == null) {
				throw new Exception('Invalid Request');
			}


			if ($request->getController() == 'index.html') {
				// if controller not specified: /satapc/ => redirected to a default_controller taken from config
				// default action is always index
				$controller = $this->_configuration->getKey('default_controller');
				$url_prefix = $this->_configuration->getKey('url_prefix');
				header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . (!empty($url_prefix) ? $url_prefix . '/' : '') . $controller);
				exit();
			}
			$controller = controller::loadController($request->getController(), $this->_configuration, $this->_resourcesLoader, $external);


			$action = $request->getAction();
			if (!method_exists($controller, $action) || !is_callable(array($controller, $action))) {
				/* index = Index */

				/* does not exists the method so must be answer 404 NF */
				$this->_response->notFound();
				return;
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