<?php

/**
 * File containing the URL class
 *
 * @version       1.0 / 2015-05-01
 * @author        akrys
 */
namespace akrys\ExtendedParseUrl;

/**
 * Description of HostFixPHP547
 *
 * @author akrys
 */
class HostFixPHP547
{
	/**
	 * Determines if the URL should be fixed if missparsed by PHP < 5.4.7
	 *
	 * This only affects hostnames wihtout scheme. Prior to PHP 5.4.7 those were
	 * considered as path instead of hostname
	 *
	 * Example 1: "//example.com/test.php" (up to PHP 5.4.7)
	 * <pre>
	 * array(1) {
	 *  ["path"]=>
	 *  string(22) "//example.com/test.php"
	 * }
	 * </pre>
	 *
	 * Example 2: "//example.com/test.php" (in PHP 5.4.7 and newer)
	 * <pre>
	 * array(2) {
	 *  'host' =>
	 *  string(11) "example.com"
	 *  'path' =>
	 *  string(9) "/test.php"
	 * }
	 * </pre>
	 *
	 * see also:
	 * https://php.net/manual/en/function.parse-url.php#refsect1-function.parse-url-changelog
	 *
	 * @var boolean
	 */
	private static $enabled = false;

	/**
	 * enable host fix
	 * @see akrys\ExtendedParseUrl\URL::$hostFixPHP547Enabled
	 */
	public static function enable()
	{
		self::$enabled = true;
	}

	/**
	 * disable Host Fix
	 * @see akrys\ExtendedParseUrl\URL::$hostFixPHP547Enabled
	 */
	public static function disable()
	{
		self::$enabled = false;
	}

	/**
	 * get current state of host fix execution
	 * @return boolean
	 * @see akrys\ExtendedParseUrl\URL::$hostFixPHP547Enabled
	 */
	public static function isEnabled()
	{
		return self::$enabled;
	}

	/**
	 * Correcting known bugs php's parse_url
	 *
	 * @param array $data
	 */
	public static function fixIt($data)
	{
		//PHP < 5.4.7 Fix
		if ($data['host'] == '' && preg_match('#^//#msi', $data['path'])) {
			$path = explode('/', ltrim($data['path'], '/'));
			$host = array_shift($path);
			$data['host'] = $host;
			if (!empty($path)) {
				$data['path'] = '/'.implode('/', $path);
			} else {
				$data['path'] = null;
			}
		}
		return $data;
	}
}