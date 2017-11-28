<?php

require "autoload.php";

$credentials = file("users.txt");

foreach ($credentials as $k => $v) {
	$v = explode("|", $v, 2);
	array_walk($v, function(&$v) {
		$v = trim($v);
	});
	/**
	 * @param string $email
	 * @param string $password
	 */
	$app = new \Bukalapak\BukalapakChecker($v[0], $v[1]);
	print " ".($k+1).". ".implode(" | ", $v) . PHP_EOL;
	$app->check();
	print "" . $app->output() . PHP_EOL;
}