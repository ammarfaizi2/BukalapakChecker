<?php
header("Content-type:application/json");

if (isset($_GET['email'], $_GET['password'])) {

	require "autoload.php";

	/**
	 * @param string $email
	 * @param string $password
	 */
	$app = new \Bukalapak\BukalapakChecker($_GET['email'], $_GET['password'], true);
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