<?

	class application {
		public function run($request) {
			if ($request == null) {
				throw new Exception('Invalid Request');
			}

			$controller = controller::loadController($request->getController());
			$action = $request->getAction();
			if (!method_exists($controller, $action) || !is_callable(array($controller, $action))) {
				throw new Exception('Action not exists.');
			}

			$controller->setAction($action);

			call_user_func(array($controller, $action), $request->getParams());
		}
	}

?>