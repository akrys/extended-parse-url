<?php

require_once __DIR__.'/../../akrys/ExtendedParseUrl/extended_parse_url.php';

class FunctionTest
	extends PHPUnit_Framework_TestCase
{

	protected function setUp()
	{
		if (!function_exists('\\akrys\\ExtendedParseUrl\\parse_url')) {
			$this->markTestSkipped(
				'Function parse_url is not available.'
			);
		}
	}

	public function testParseUrlsWrongURL()
	{
		//testing a wrong URL
		$url = '';
		$this->assertFalse(\akrys\ExtendedParseUrl\parse_url($url));
	}

	public function testParseResult()
	{
		//testing an URL
		$url = 'http://example.com/';
		$parsed = \akrys\ExtendedParseUrl\parse_url($url);

		$this->assertArrayHasKey('scheme', $parsed); //1
		$this->assertArrayHasKey('host', $parsed); //2
		$this->assertArrayHasKey('port', $parsed); //3
		$this->assertArrayHasKey('user', $parsed); //4
		$this->assertArrayHasKey('pass', $parsed); //5
		$this->assertArrayHasKey('path', $parsed); //6
		$this->assertArrayHasKey('query', $parsed); //7
		$this->assertArrayHasKey('fragment', $parsed); //8
		$this->assertArrayHasKey('dirname', $parsed); //9
		$this->assertArrayHasKey('basename', $parsed); //10
		$this->assertArrayHasKey('patharray', $parsed); //11
		$this->assertArrayHasKey('parameter', $parsed); //12
		$this->assertArrayHasKey('hostarray', $parsed); //12
		$this->assertEquals(13, count($parsed), 'Number of fields not correct');
	}
}