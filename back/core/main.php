<?
	include('class/request.php');
	include('class/application.php');


	$request = new request($_GET['controller'], $_GET['action'], $_POST);
	$app = new application();
	$app->run($request);
?>