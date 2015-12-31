<?
	include_once('class/request.php');
	include_once('class/application.php');
	include_once('class/controller.php');

	$params = array_merge ($_GET, $_POST);
	
	unset($params['controller']);
	unset($params['action']);

	$request = new request($_GET['controller'], $_GET['action'], $params);
	$app = new application();
	$app->run($request);
?>