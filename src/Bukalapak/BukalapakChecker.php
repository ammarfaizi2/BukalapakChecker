<?php

namespace Bukalapak;

use Bukalapak\Crawlers\Login;
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
	private $hash;

	/**
	 * @var string
	 */
	private $json;

	final public function __construct($email, $password)
	{
		$this->email    = $email;
		$this->password = $password;
		$this->hash = sha1($email.$password);
	}

	/**
	 * @return bool
	 */
	final public function check()
	{
		$crawler = new Login($this);
		$crawler->action();
		$this->loginStatus = $crawler->get();
	}

	final public function hash()
	{
		return $this->hash;
	}

	/**
	 * @return string
	 */
	final public function output()
	{
		return $this->json;
	}
}