<?php

namespace Bukalapak;

use Bukalapak\Contracts\BukalapakChecker as BukalapakCheckerContracts;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @link https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
final class BukalapakChecker implements BukalapakCheckerContracts
{
	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $json;

	final public function __construct($email, $password)
	{
		$this->email    = $email;
		$this->password = $password;
	}

	final public function check()
	{

	}

	final public function output()
	{
		return $this->json;
	}
}