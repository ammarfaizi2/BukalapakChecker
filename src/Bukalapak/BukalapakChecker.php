<?php

namespace Bukalapak;

use Bukalapak\Crawlers\Login;
use Bukalapak\Crawlers\BukaDompet;
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
	public $email;

	/**
	 * @var string
	 */
	public $password;

	/**
	 * @var string
	 */
	public $hash;

	/**
	 * @var bool
	 */
	public $apiRequest;

	/**
	 * @var string
	 */
	private $json;

	final public function __construct($email, $password, $apiRequest = false)
	{
		$this->email    = $email;
		$this->password = $password;
		$this->hash = sha1($email.$password);
		$this->apiRequest = $apiRequest;
	}

	/**
	 * @return bool
	 */
	final public function check()
	{
		$crawler = new Login($this);
		$crawler->action();
		if ($crawler->get()) {
			$crawler = new BukaDompet($this);
			$crawler->action();
			$result = ["email" => $this->email, "password" => $this->password, "result" => ["status" => "live", "data" => $crawler->get()]];
		} else {
			$result = ["email" => $this->email, "password" => $this->password, "result" => ["status" => "die", "data" => new \StdClass]];
		}
		$this->json = json_encode($result);
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