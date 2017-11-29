<?php

namespace Bukalapak\Crawlers;

use Curl;
use Bukalapak\Crawlers;
use Bukalapak\BukalapakChecker;
use Bukalapak\Contracts\Crawlers as CrawlersContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @link https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @see \Bukalapak\BukalapakChecker
 */
class BukaDompet extends Crawlers implements CrawlersContract
{	
	/**
	 * @var \Bukalapak\BukalapakChecker
	 */
	private $ins;

	/**
	 * @var array
	 */
	private $context = [];

	/**
	 * @var string
	 */
	private $saldo;

	/**
	 * Constructor.
	 *
	 * @param \Bukalapak\BukalapakChecker $instance
	 */
	public function __construct(BukalapakChecker $instance)
	{
		$this->ins = $instance;
	}

	/**
	 * @return bool
	 */
	public function action()
	{
		$this->ins->apiRequest or print "   Cek BukaDompet..." . PHP_EOL . "   ";
		$this->saldo = $this->getBukaDompet();
	}

	private function getBukaDompet()
	{
		$ch = new Curl("https://m.bukalapak.com/dompet?from=user_panel");
		$ch->userAgent("Opera/9.80 (Android; Opera Mini/19.0.2254/37.9389; U; en) Presto/2.12.423 Version/12.11");
		$ch->cookieJar(COOKIEPATH . "/" . $this->ins->hash);
		$a = $ch->exec();
		$a = explode("Saldo:", $a, 2);
		$a = explode("<br>", $a[1], 2);
		$a = explode("<span class='amount positive'>", $a[0], 2);
		$a = explode("<", $a[1], 2);
		return $a[0];
	}

	/**
	 * @return string
	 */
	public function get()
	{
		return ["saldo_buka_dompet" => $this->saldo];
	}
}