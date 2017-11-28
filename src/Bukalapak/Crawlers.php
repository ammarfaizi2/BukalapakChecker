<?php

namespace Bukalapak;

use Bukalapak\BukalapakChecker;

abstract class Crawlers
{
	/**
	 * @var \Bukalapak\BukalapakChecker
	 */
	private $ins;

	/**
	 * @var string
	 */
	private $result;

	/**
	 * Constructor.
	 *
	 * @param $instance Bukalapak\BukalapakChecker
	 */
	abstract public function __construct(BukalapakChecker $instance);

	/**
	 * @return bool
	 */
	abstract public function action();

	/**
	 * @return string
	 */
	abstract public function get();
}