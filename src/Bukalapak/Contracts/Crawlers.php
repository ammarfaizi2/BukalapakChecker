<?php

namespace Bukalapak\Contracts;

interface Crawlers
{
	/**
	 * Constructor.
	 *
	 * @param $instance Bukalapak\BukalapakChecker
	 */
	public function __construct(BukalapakChecker $instance);

	/**
	 * @return bool
	 */
	public function action();

	/**
	 * @return string
	 */
	public function get();
}