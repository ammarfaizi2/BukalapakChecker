<?php

namespace Bukalapak\Contracts;

interface BukalapakChecker
{
	public function __construct($email, $password);

	public function check();

	public function output();
}