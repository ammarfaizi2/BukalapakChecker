<?php

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
	 * @var array $opt
	 */
	public function setopt($opt)
	{
		if (! is_array($opt)) {
			throw new \Exception("setopt parameter must be array ".gettype($opt)." given.", 1);
		}
		$this->userOpt = $opt;
	}

	public function exec()
	{
		$ch = curl_init($this->url);
		$this->buildOptContext();
		curl_setopt_array($ch, $this->defaultOpt);
		$out = curl_exec($ch);
		$this->info  = curl_getinfo($ch);
		$this->errno = curl_errno($ch);
		$this->error = curl_error($ch);
	}

	private function buildOptContext()
	{
		foreach ($this->userOpt as $k => $v) {
			$this->defaultOpt[$k] = $v;
		}
	}
}