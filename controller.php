<?php
header("Content-type:application/json");

if (isset($_GET['email'], $_GET['password'])) {

	require "autoload.php";

	/**
	 * @param string $email
	 * @param string $password
	 */
	$app = new \Bukalapak\BukalapakChecker(trim($_GET['email']), trim($_GET['password']), true);
	if (isset($_GET['socks'])) {
		$app->socks(trim($_GET['socks']));
	}
	$app->check();
	print $app->output();
} else {
	http_response_code(400);
	print json_encode(
		[
			"status" => "error",
			"message" => "Bad Request: parameter required!"
		]
	);
}