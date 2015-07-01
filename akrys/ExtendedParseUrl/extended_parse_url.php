<?php

/**
 * File containing parse_url
 *
 * @version       1.0 / 2015-04-26
 * @author        akrys
 */
namespace akrys\ExtendedParseUrl;

require_once __DIR__.'/URL.php';

/**
 * Providing the standard PHP interface.
 *
 * Mostly compatible to {@link http://php.net/manual/en/function.parse-url.php \parse_url()}
 *
 * The 2nd parameter which can be provided in the original php function can't
 * be supported here, because there are no constants for the additional values.
 *
 * As this function wants to be compatible to {@link http://php.net/manual/en/function.parse-url.php \parse_url()}
 * it returns <tt>false</tt> (instead of throwing exceptions) in case of
 * failiures.
 *
 * @return array|boolean
 * @param $url string
 * @author akrys
 */
function parse_url($url)
{
	try {
		$obj = new URL($url);
		return $obj->parse();
	} catch (\Exception $e) {
		//some error handling one could think of.
		//for simple dev purposes, a simple var_dump should be enough
//		print $e->getMessage();
//		var_dump($e->getTraceAsString());
	}

	return false;
}
