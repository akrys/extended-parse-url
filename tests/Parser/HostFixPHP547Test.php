<?php

require_once __DIR__.'/../../akrys/ExtendedParseUrl/HostFixPHP547.php';

class HostFixPHP547Test
	extends PHPUnit_Framework_TestCase
{

	public function testHostFix()
	{
		//simulate php 5.3 parsing behavior to test the host fix
		//here with path
		$data = array('host' => '', 'path' => '//example.com/path/to/nothing.php');
		$result = akrys\ExtendedParseUrl\HostFixPHP547::fixIt($data);

		$this->assertEquals('example.com', $result['host']);
		$this->assertEquals('/path/to/nothing.php', $result ['path']);
	}

	public function testHostFixWithoutPath()
	{
		//simulate php 5.3 parsing behavior to test the host fix
		//here without path
		$data = array('host' => '', 'path' => '//example.com');
		$result = akrys\ExtendedParseUrl\HostFixPHP547::fixIt($data);

		$this->assertEquals('example.com', $result['host']);
		$this->assertNull($result ['path']);
	}

	public function testHostFixWithoutPathSlash()
	{
		//simulate php 5.3 parsing behavior to test the host fix
		//here a single slash (/) as a path
		$data = array('host' => '', 'path' => '//example.com/');
		$result = akrys\ExtendedParseUrl\HostFixPHP547::fixIt($data);

		$this->assertEquals('example.com', $result['host']);
		$this->assertEquals('/', $result ['path']);
	}

	public function testHostFixEnable()
	{
		//testing hostfix enabled
		\akrys\ExtendedParseUrl\HostFixPHP547::enable();
		$ref = new ReflectionProperty('akrys\\ExtendedParseUrl\\HostFixPHP547', 'enabled');
		$ref->setAccessible(true);
		$this->assertTrue($ref->getValue());
		$this->assertTrue(\akrys\ExtendedParseUrl\HostFixPHP547::isEnabled());
	}

	public function testHostFixDisable()
	{
		//testing hostfix disable
		\akrys\ExtendedParseUrl\HostFixPHP547::disable();
		$ref = new ReflectionProperty('akrys\\ExtendedParseUrl\\HostFixPHP547', 'enabled');
		$ref->setAccessible(true);
		$this->assertFalse($ref->getValue());
		$this->assertFalse(\akrys\ExtendedParseUrl\HostFixPHP547::isEnabled());
	}
}