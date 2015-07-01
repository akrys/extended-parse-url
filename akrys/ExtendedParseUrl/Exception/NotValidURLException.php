<?php

/**
 * File containing NotValidURLException class
 *
 * @version       1.0 / 2015-04-26
 * @author        akrys
 */
namespace akrys\ExtendedParseUrl\Exception;

/**
 * Exception thrown, if an url is not valid
 *
 * @author akrys
 */
class NotValidURLException
	extends \Exception
{
	/**
	 * invalid URL
	 * @var string
	 */
	private $url;

	/**
	 * Constructor
	 * @param string $url invalid URL
	 */
	public function __construct($url)
	{
		$this->url = $url;
		parent::__construct('not a valid URL', 0, null);
	}

	/**
	 * Get the url that is invalid.
	 *
	 * if wanted, this can be included into error messages
	 *
	 * @return string
	 */
	public function getURL()
	{
		return $this->url;
	}
}