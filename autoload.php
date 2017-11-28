<?php

define("BASEPATH", __DIR__);

/**
 * Class loader.
 */
spl_autoload_register(function ($class) {
	require __DIR__ . "/src/". str_replace($class, "\\", "/").".php";
});