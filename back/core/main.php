<?
	include_once('class/request.php');
	include_once('class/application.php');
	include_once('class/controller.php');


	$request = new request($_GET['controller'], $_GET['action'], $_POST);
	$app = new application();
	$app->run($request);
?>