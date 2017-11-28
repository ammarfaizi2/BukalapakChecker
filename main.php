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
	$app = new BukalapakChecker($v[0], $v[1]);
	$app->check();
	print " ".$k.". " . $app->output() . PHP_EOL;
}