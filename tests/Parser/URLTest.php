<?php

require_once __DIR__.'/../../akrys/ExtendedParseUrl/URL.php';

class URLTest
	extends PHPUnit_Framework_TestCase
{
// <editor-fold defaultstate="collapsed" desc="setup Magic Quotes handling PHP 5.3">
	/**
	 * There are some Problems concerning magic Quotes in PHP 5.3
	 *
	 * Even the magic quotes settings are deprecated, they are still working in
	 * PHP 5.3
	 *
	 * @var boolean
	 */
	private $magicQuotesEnabled;

	protected function setUp()
	{
		if (!class_exists('\\akrys\\ExtendedParseUrl\\URL')) {
			$this->markTestSkipped(
				'Class Parser is not available.'
			);
		}

		//Lovely Magic Quotes… As the code also runs on PHP 5.3 we should be so
		//kind and test it that, too…
		$magicQuotes = ini_get('magic_quotes_gpc');
		if ($magicQuotes === false) {
			//=> not defined (i.e. PHP 5.5)
			$this->magicQuotesEnabled = false;
		} else {
			switch ($magicQuotes) {
				case '':
					//defined as off
					$this->magicQuotesEnabled = false;
					break;
				case '1':
					//defined as on
					$this->magicQuotesEnabled = true;
					break;
			}
		}
	}

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Constructor tests">
	public function testClass()
	{
		//class constrct test
		$url = new akrys\ExtendedParseUrl\URL('test');
		$this->assertInstanceOf('akrys\\ExtendedParseUrl\\URL', $url);
	}

	public function testNotValidURL()
	{
		//construct with a not valid URL
		//this should throw an exception
		$this->setExpectedException('akrys\\ExtendedParseUrl\\Exception\\NotValidURLException');
		$url = new akrys\ExtendedParseUrl\URL('');
	}

	public function testCastToString()
	{
		//casting to string should give us the URL
		$url = new akrys\ExtendedParseUrl\URL('test');
		$this->assertEquals('test', (string) $url);
	}

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Getter Tests">
	public function testGetURL()
	{
		//Function test for getURL
		$url = new akrys\ExtendedParseUrl\URL('test');
		$this->assertEquals('test', $url->getURL());
	}

	public function testGetScheme()
	{
		//function test getScheme
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('http', $u->getScheme());
	}

	public function testGetHost()
	{
		//function test getHost
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('www.example.com', (string) $u->getHost());
	}

	public function testGetPort()
	{
		//function test getPort
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('8080', (string) $u->getPort());
	}

	public function testGetUser()
	{
		//function test getUser
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('testUser:testpass', $u->getUser());
	}

	public function testGetUserArray()
	{
		//function test getUserArray
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals(array('user' => 'testUser', 'password' => 'testpass'), $u->getUserArray());
	}

	public function testGetPath()
	{
		//function test getPath

		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('/path/to/specific/file.php', (string) $u->getPath());
	}

	public function testGetQuery()
	{
		//function test getQuery
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('test=1', (string) $u->getQuery());
	}

	public function testGetFragment()
	{
		//function test getFragment
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('afragment', (string) $u->getFragment());
	}

	public function testGetUserName()
	{
		//function test getUsername
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('testUser', (string) $u->getUserName());
	}

	public function testgetUserPassword()
	{
		//function test getUserPassword
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('testpass', $u->getUserPassword());
	}

	public function testGetDirname()
	{
		//function test getDirname
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('/path/to/specific', $u->getDirname());
	}

	public function testGetBasename()
	{
		//function test getBasename
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals('file.php', (string) $u->getBasename());
	}

	public function testGetPathArray()
	{
		//function test getPathArray
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals(array('path', 'to', 'specific', 'file.php'), $u->getPathArray());
	}

	public function testGetParameter()
	{
		//function test getParameter
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals(array('test' => 1), $u->getParameter());
	}

	public function testGetHostArray()
	{
		//function test getHostArray
		$url = 'http://testUser:testpass@www.example.com:8080/path/to/specific/file.php?test=1#afragment';
		$u = new \akrys\ExtendedParseUrl\URL($url);
		$this->assertEquals(array('www', 'example', 'com'), $u->getHostArray());
	}

	public function testFunctionParseURLHostArray()
	{
		//get HostArray test
		$url = new akrys\ExtendedParseUrl\URL('http://www.test.example.com');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('www.test.example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array(), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('www', 'test', 'example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testFunctionPort()
	{
		//get Port Function
		$url = new akrys\ExtendedParseUrl\URL('http://example.com:14001/sites/test/test?test[aa][][cc]=1&test[aa][][dd]=2&test[aa][dd]=3');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('14001', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('test[aa][][cc]=1&test[aa][][dd]=2&test[aa][dd]=3', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array('sites', 'test', 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array('test' => array('aa' => array(0 => array('cc' => '1',), 1 => array('dd' => '2',), 'dd' => '3',),),), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testFunctionLongPort()
	{
		//port number is too high
		$this->setExpectedException('akrys\\ExtendedParseUrl\\Exception\\NotValidURLException');
		$url = new akrys\ExtendedParseUrl\URL('http://example.com:140015/sites/test/test?test[aa][][cc]=1&test[aa][][dd]=2&test[aa][dd]=3');
	}

	public function testFunctionStringPort()
	{
		//prot number is a string
		$this->setExpectedException('akrys\\ExtendedParseUrl\\Exception\\NotValidURLException');
		$url = new akrys\ExtendedParseUrl\URL('http://example.com:140NONVALIDNUMBER/sites/test/test?test[aa][][cc]=1&test[aa][][dd]=2&test[aa][dd]=3');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('140NONVALIDNUMBER015', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('test[aa][][cc]=1&test[aa][][dd]=2&test[aa][dd]=3', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array('sites', 'public', 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array('test' => array('aa' => array(0 => array('cc' => '1',), 1 => array('dd' => '2',), 'dd' => '3',),),), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Schemeless tests (HostFix / PHP 5.3)">
	public function testFunctionParseURLWithoutScheme()
	{
		//test case URL wihtout scheme
		$url = new akrys\ExtendedParseUrl\URL('//example.com/?test/9)4/3');

		$host = $url->getHost();

		//As this test can run on PHP < 5.4.7 and PHP >= 5.4.7, both scenarios
		//are correct
		if ($host == '' && !\akrys\ExtendedParseUrl\HostFixPHP547::isEnabled()) {
			//expected behavior in PHP < 5.4.7
			$this->assertEquals('', $host, 'wrong path'); //6
			$this->assertEquals('//example.com/', $url->getPath(), 'wrong path'); //6
			$this->assertEquals('/', $url->getDirname(), 'wrong dirname'); //9
			$this->assertEquals('example.com', $url->getBasename(), 'wrong basename'); //10
			$this->assertEquals(array(0 => 'example.com'), $url->getPathArray(), 'wrong patharray'); //11
			$this->assertEquals(array(), $url->getHostArray(), 'wrong host array'); //13
		} else {
			//expected behavior in PHP >= 5.4.7 or with Hostname-Fix enabled
			$this->assertEquals('example.com', $host, 'wrong host'); //2
			$this->assertEquals('/', $url->getPath(), 'wrong path'); //6
			$this->assertEquals('/', $url->getDirname(), 'wrong dirname'); //9
			$this->assertEquals('', $url->getBasename(), 'wrong basename'); //10
			$this->assertEquals(array(0 => ''), $url->getPathArray(), 'wrong patharray'); //11
			$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
		}

		//Components that don't differ
		$this->assertEquals('', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('test/9)4/3', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals(array('test/9)4/3' => ''), $url->getParameter(), 'wrong parameter'); //12
	}

	public function testFunctionParseURLWithoutSchemeSpaces()
	{
		//test case URL wihtout scheme
		//there could be some problems with spaces in the beginning. So we have
		//to test if this is working correctly
		$url = new akrys\ExtendedParseUrl\URL(' //example.com/path/to/nothing.php?test/9)4/3 ');

		//As this test can run on PHP < 5.4.7 and PHP >= 5.4.7, both scenarios
		//are correct
		$host = $url->getHost();
		if ($host == '' && !\akrys\ExtendedParseUrl\HostFixPHP547::isEnabled()) {
			//expected behavior in PHP < 5.4.7
			$this->assertEquals('', $host, 'wrong path'); //6
			$this->assertEquals('//example.com/path/to/nothing.php', $url->getPath(), 'wrong path'); //6
			$this->assertEquals('//example.com/path/to', $url->getDirname(), 'wrong dirname'); //9
			$this->assertEquals('nothing.php', $url->getBasename(), 'wrong basename'); //10
			$this->assertEquals(array('example.com', 'path', 'to', 'nothing.php'), $url->getPathArray(), 'wrong patharray'); //11
			$this->assertEquals(array(), $url->getHostArray(), 'wrong host array'); //13
		} else {
			//expected behavior in PHP >= 5.4.7 or with Hostname-Fix enabled
			$this->assertEquals('example.com', $host, 'wrong host'); //2
			$this->assertEquals('/path/to/nothing.php', $url->getPath(), 'wrong path'); //6
			$this->assertEquals('/path/to', $url->getDirname(), 'wrong dirname'); //9
			$this->assertEquals('nothing.php', $url->getBasename(), 'wrong basename'); //10
			$this->assertEquals(array('path', 'to', 'nothing.php'), $url->getPathArray(), 'wrong patharray'); //11
			$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
		}

		//Components that don't differ
		$this->assertEquals('', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('test/9)4/3', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals(array('test/9)4/3' => ''), $url->getParameter(), 'wrong parameter'); //12
	}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Parameter Tests">
	public function testFunctionParseURLWithParameter()
	{
		//test the behavior, if there is a parameter value with an escape sequence
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test?id=2622');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('id=2622', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(0 => 'sites', 1 => 'test', 2 => 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array('id' => '2622'), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testFunctionParseURLWithoutParameter()
	{
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(0 => 'sites', 1 => 'test', 2 => 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array(), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testFunctionParseURLMoreEqualSigns()
	{
		//test the behavior, if there is an equal sign in a parameter value
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test?id=2622&te=st=1&t=test');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('id=2622&te=st=1&t=test', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(0 => 'sites', 1 => 'test', 2 => 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array('id' => '2622', 'te' => 'st=1', 't' => 'test'), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testFunctionParseURLParameterWithoutValue()
	{
		//test the behavior, if there is a parameter without value
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test?id=2622&test=1&t');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('id=2622&test=1&t', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(0 => 'sites', 1 => 'test', 2 => 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array('id' => '2622', 'test' => '1', 't' => ''), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testFunctionParseURLEscapedKey()
	{
		//test the behavior, if there is a parameter name with an escape sequence
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test?id=2622&test=1&t\2');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('id=2622&test=1&t\2', $url->getQuery(), 'wrong query'); //7
		$this->assertNotEquals("id=2622&test=1&t\2", $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(0 => 'sites', 1 => 'test', 2 => 'test'), $url->getPathArray(), 'wrong patharray'); //11
		if (!$this->magicQuotesEnabled) {
			$this->assertEquals(array('id' => '2622', 'test' => '1', 't\2' => ''), $url->getParameter(), 'wrong parameter'); //12
		} else {
			//magic quotes are magic…
			$this->assertEquals(array('id' => '2622', 'test' => '1', 't\\\2' => ''), $url->getParameter(), 'wrong parameter'); //12
		}
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testFunctionParseURLEscapedValue()
	{
		//test the behavior, if there is a parameter value with an escape sequence
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test?id=2622&test=1&t=t\4');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('id=2622&test=1&t=t\4', $url->getQuery(), 'wrong query'); //7
		$this->assertNotEquals("id=2622&test=1&t=t\4", $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(0 => 'sites', 1 => 'test', 2 => 'test'), $url->getPathArray(), 'wrong patharray'); //11
		if ($this->magicQuotesEnabled) {
			$this->assertEquals(array('id' => '2622', 'test' => '1', 't' => 't\\\4'), $url->getParameter(), 'wrong parameter'); //12
		} else {
			$this->assertEquals(array('id' => '2622', 'test' => '1', 't' => 't\4'), $url->getParameter(), 'wrong parameter'); //12
		}
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testArrayParameter()
	{
		//test case with parameter array
		$url = new akrys\ExtendedParseUrl\URL('http://www.test.example.com?test[]=2&test[]=3');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('www.test.example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('test[]=2&test[]=3', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array("test" => array(2, 3)), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('www', 'test', 'example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testArrayParameterOverwrite()
	{
		//test case: a value that is defined multiple times
		$url = new akrys\ExtendedParseUrl\URL('http://www.test.example.com?test[]=2&test=3');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('www.test.example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('test[]=2&test=3', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array("test" => 3), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('www', 'test', 'example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testMultidimArrayParameterWithSuffixInName()
	{
		//parameter as array with letters after Array characters ("[]")
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test?test[ee]=2&test[aa][t]=3&test[ee][2]%29=1');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('test[ee]=2&test[aa][t]=3&test[ee][2]%29=1', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array('sites', 'test', 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array("test" => array('aa' => array('t' => 3), 'ee' => array('2' => 1))), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testMultidimArrayParameterCutOffName()
	{
		//parameter as array with letters between 2 Array indeces
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test?test[ee]=2&test[aa][t]=3&test[ee]test[2]=1');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('test[ee]=2&test[aa][t]=3&test[ee]test[2]=1', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array('sites', 'test', 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array('test' => array('ee' => '1', 'aa' => array('t' => '3',),),), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testMultidimArrayParameter()
	{
		//test case: multi dimensional parameter arrays
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test?test[aa][bb][cc]=1&test[aa][bb][dd]=2&test[aa][dd]=3');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('test[aa][bb][cc]=1&test[aa][bb][dd]=2&test[aa][dd]=3', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array('sites', 'test', 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array('test' => array('aa' => array('bb' => array('cc' => '1', 'dd' => '2',), 'dd' => '3',),),), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testMultidimArrayParameterNumeric()
	{
		//mulit dimensional parameter array with numeric index
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test?test[aa][][cc]=1&test[aa][][dd]=2&test[aa][dd]=3');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('test[aa][][cc]=1&test[aa][][dd]=2&test[aa][dd]=3', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array('sites', 'test', 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array('test' => array('aa' => array(0 => array('cc' => '1',), 1 => array('dd' => '2',), 'dd' => '3',),),), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array('example', 'com'), $url->getHostArray(), 'wrong host array'); //13
	}

// </editor-fold>

	public function testFunctionParseURLWithParamterWithFragment()
	{
		//fragment test, if there are parameters
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test?id=2622&test=1#testfragment');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('id=2622&test=1', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('testfragment', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(0 => 'sites', 1 => 'test', 2 => 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array('id' => 2622, 'test' => 1), $url->getParameter(), 'wrong host array'); //12
	}

	public function testFunctionParseURLWithoutParameterWithFragment()
	{
		//fragment test, if there are no parameters
		$url = new akrys\ExtendedParseUrl\URL('http://example.com/sites/test/test#testfragment');

		$this->assertEquals('http', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('example.com', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('testfragment', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(0 => 'sites', 1 => 'test', 2 => 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array(), $url->getParameter(), 'wrong host array'); //12
	}

	public function testFunctionParseURLWithoutHostRelativePathWithParamterWithFragment()
	{
		//relative URL with parameters and a fragment
		$url = new akrys\ExtendedParseUrl\URL('sites/test/test?id=2622&te=st=1&t#testfragment');

		$this->assertEquals('', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('id=2622&te=st=1&t', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('testfragment', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(0 => 'sites', 1 => 'test', 2 => 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array('id' => '2622', 'te' => 'st=1', 't' => ''), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array(), $url->getHostArray(), 'wrong host array'); //13
	}

	public function testFunctionParseURLWithoutHostAbsoultePath()
	{
		//absolute URL (without hostname) with parameters and a fragment
		$url = new akrys\ExtendedParseUrl\URL('/sites/test/test');

		$this->assertEquals('', $url->getScheme(), 'wrong scheme'); //1
		$this->assertEquals('', $url->getHost(), 'wrong host'); //2
		$this->assertEquals('', $url->getPort(), 'wrong port'); //3
		$this->assertEquals('', $url->getUserName(), 'wrong user'); //4
		$this->assertEquals('', $url->getUserPassword(), 'wrong pass'); //5
		$this->assertEquals('/sites/test/test', $url->getPath(), 'wrong path'); //6
		$this->assertEquals('', $url->getQuery(), 'wrong query'); //7
		$this->assertEquals('', $url->getFragment(), 'wrong fragment'); //8
		$this->assertEquals('/sites/test', $url->getDirname(), 'wrong dirname'); //9
		$this->assertEquals('test', $url->getBasename(), 'wrong basename'); //10
		$this->assertEquals(array(0 => 'sites', 1 => 'test', 2 => 'test'), $url->getPathArray(), 'wrong patharray'); //11
		$this->assertEquals(array(), $url->getParameter(), 'wrong parameter'); //12
		$this->assertEquals(array(), $url->getHostArray(), 'wrong host array'); //13
	}
}