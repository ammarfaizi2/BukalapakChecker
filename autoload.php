<?php

define("BASEPATH", __DIR__);
define("COOKIEPATH", __DIR__."/dat");

is_dir(COOKIEPATH) or mkdir(COOKIEPATH);

/**
 * Class loader.
 */
spl_autoload_register(function ($class) {
	require __DIR__ . "/src/". str_replace("\\", "/", $class).".php";
});