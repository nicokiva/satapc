<?

	class application {
		function run($request) {
			if ($request == null) {
				throw new Exception('Invalid Request');
			}

			$controller = controller::loadController($request->getController());
			$action = $request->getAction();
			if (!method_exists($controller, $action) || !is_callable(array($controller, $action))) {
				return;
			}

echo '1';
			$controller->$$action();
		}
	}


?>