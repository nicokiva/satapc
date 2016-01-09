<?
	include_once('class/configuration.php');
	include_once('class/resourceLoader.php');

	include_once('class/request.php');
	include_once('class/application.php');
	include_once('class/controller.php');

	include_once('../external/mailer/mailer.php');

	$params = array_merge ($_GET, $_POST);
	unset($params['controller']);
	unset($params['action']);

	$configuration = new configuration();
	$resourceLoader = new resourceLoader($configuration->getKey('site_name'));


	$external = array('mailer' => new mailer($configuration));

	$request = new request($_GET['controller'], $_GET['action'], $params);
	$app = new application($configuration, $resourceLoader);
	$app->run($request, $external);
?>