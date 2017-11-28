<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @link https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
final class Curl
{
	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var resource
	 */
	private $ch;

	/**
	 * @var array
	 */
	private $userOpt = [];

	/**
	 * @var array
	 */
	private $defaultOpt = [];

	/**
	 * @var string
	 */
	private $error;

	/**
	 * @var int
	 */
	private $errno;

	/**
	 * Constructor.
	 *
	 * @param string $url
	 */
	public function __construct($url)
	{
		$this->url = $url;
		$this->defaultOpt = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_FOLLOWLOCATION => true
		];
	}

	/**
	 * @param array $opt
	 */
	public function setOpt($opt)
	{
		if (! is_array($opt)) {
			throw new \Exception("setopt parameter must be array ".gettype($opt)." given.", 1);
		}
		$this->userOpt = $opt;
	}

	/**
	 * @param string $userAgent
	 */
	public function userAgent($userAgent)
	{
		$this->defaultOpt[CURLOPT_USERAGENT] = $userAgent;
	}

	/**
	 * @param array|string $data
	 */
	public function postData($data, $urlencoded = false)
	{
		$this->defaultOpt[CURLOPT_POST] = true;
		if (is_array($data) && $urlencoded) {
			$this->defaultOpt[CURLOPT_POSTFIELDS] = http_build_query($data);
		} else {
			$this->defaultOpt[CURLOPT_POSTFIELDS] = $data;
		}
	}

	public function cookieJar($file)
	{
		$this->defaultOpt[CURLOPT_COOKIEJAR] = $file;
		$this->defaultOpt[CURLOPT_COOKIEFILE] = $file;
	}

	/**
	 * Exec curl.
	 */
	public function exec()
	{
		$ch = curl_init($this->url);
		$this->buildOptContext();
		curl_setopt_array($ch, $this->defaultOpt);
		$out = curl_exec($ch);
		$this->info  = curl_getinfo($ch);
		$this->errno = curl_errno($ch);
		$this->error = curl_error($ch);
		curl_close($ch);
		return $out;
	}

	/**
	 * Build curl context opt.
	 */
	private function buildOptContext()
	{
		foreach ($this->userOpt as $k => $v) {
			$this->defaultOpt[$k] = $v;
		}
	}

	/**
	 * @return string
	 */
	public function error()
	{
		return $this->error;
	}

	/**
	 * @return int
	 */
	public function errno()
	{
		return $this->errno;
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function info($key = false)
	{
		return $key ? $this->info[$key] : $this->info;
	}
}