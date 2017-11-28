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
class Login extends Crawlers implements CrawlersContract
{	
	/**
	 * @var \Bukalapak\BukalapakChecker
	 */
	private $ins;

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
		$this->getLoginPage();
	}

	public function getLoginPage()
	{
		$ch = new Curl("https://m.bukalapak.com/login");
		$ch->userAgent("Opera/9.80 (Android; Opera Mini/19.0.2254/37.9389; U; en) Presto/2.12.423 Version/12.11");
		$ch->cookieJar(COOKIEPATH."/");
		$out = $ch->exec();
		file_put_contents("a.tmp", $out);
	}

	/**
	 * @return string
	 */
	public function get()
	{

	}
}