<?php

class NotValidURLTest
	extends PHPUnit_Framework_TestCase
{

	public function testNotValidURLException()
	{
		//Testing URL Exception
		try {
			require_once __DIR__.'/../../../akrys/ExtendedParseUrl/Exception/NotValidURLException.php';
			throw new \akrys\ExtendedParseUrl\Exception\NotValidURLException('non good URL');
		} catch (\akrys\ExtendedParseUrl\Exception\NotValidURLException $e) {
			$this->assertEquals('non good URL', $e->getURL());
		}
	}
}