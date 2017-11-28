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
	 * @var array
	 */
	private $context = [];

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
		print "   Login... ";
		$this->buildLoginContext();
		$this->submitLogin();
	}

	private function buildLoginContext()
	{
		$ch = new Curl("https://m.bukalapak.com/login");
		$ch->userAgent("Opera/9.80 (Android; Opera Mini/19.0.2254/37.9389; U; en) Presto/2.12.423 Version/12.11");
		$ch->cookieJar(COOKIEPATH . "/" . $this->ins->hash);
		$out = $ch->exec();
		file_put_contents("a.tmp", $out);
		$context = [];
		$a = file_get_contents("a.tmp");
		$a = explode('<form novalidate="novalidate" class="new_user_session" ', $a, 2);
		if (isset($a[1])) {
			$a = explode('</form>', $a[1], 2);
			self::buildHiddenInput($a[0], $context);
			$cotext['user_session[username]'] = $this->ins->email;
			$context['user_session[password]'] = $this->ins->password;
			$context['commit'] = "login";
			$this->context = $context;
		}
	}

	private function submitLogin()
	{
		if ($this->context) {
			$ch = new Curl("https://m.bukalapak.com/user_sessions");
			$ch->userAgent("Opera/9.80 (Android; Opera Mini/19.0.2254/37.9389; U; en) Presto/2.12.423 Version/12.11");
			$ch->postData($this->context, true);
			$ch->cookieJar(COOKIEPATH . "/" . $this->ins->hash);
			$out = $ch->exec();
		}
	}


	/**
	 *
	 * @param array $data
	 * @param array &$context
	 * @return array
	 */
	private static function buildHiddenInput($data, &$context)
	{
		$a = explode("<input", $data);
		foreach ($a as $val) {
			if (count(explode("type=\"hidden\"", $val, 2)) > 1) {
				$b = explode(">", $val, 2);
				$b = explode("name=\"", $b[0], 2);
				$b = explode("\"", $b[1], 2);
				$c = explode("value=\"", $val, 2);
				if (isset($c[1])) {
					$c = explode("\"", $c[1], 2);
				} else {
					$c[0] = "";
				}
				$context[html_entity_decode($b[0], ENT_QUOTES, 'UTF-8')] = html_entity_decode($c[0], ENT_QUOTES, 'UTF-8');
			}
		}
		return $context;
	}

	/**
	 * @return string
	 */
	public function get()
	{
		if (strpos(file_get_contents(COOKIEPATH . "/" . $this->ins->hash), "track_login	true") !== false) {
			print "OK!" . PHP_EOL;
			return true;
		} else {
			print "Login Failed!".PHP_EOL."   ";
			return false;
		}
	}
}