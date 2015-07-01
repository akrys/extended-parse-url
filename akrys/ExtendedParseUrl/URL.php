<?php

/**
 * File containing the URL class
 *
 * @version       1.0 / 2015-05-01
 * @author        akrys
 */
namespace akrys\ExtendedParseUrl;

require_once __DIR__.'/HostFixPHP547.php';

/**
 * Description of URL
 *
 * URL Prepresentation, central point of processing URLs.
 *
 * This class also handles the object oriented API.
 *
 * @author akrys
 */
final class URL
{
	/**
	 * data array.
	 *
	 * This filled with the result of {@link parse_url()}
	 *
	 * @var array
	 */
	private $data = array();

	/**
	 * The keys which should be always set in the result array
	 * @var array
	 */
	private $baseKeys = array(
		'scheme',
		'host',
		'port',
		'user',
		'pass',
		'path',
		'query',
		'fragment',
	);

	/**
	 * The URL to be parsed
	 * @var string
	 */
	private $url;

	/**
	 * get the current URL
	 * @return string
	 */
	public function getURL()
	{
		return $this->url;
	}

	/**
	 * get the URL's scheme value
	 * @return Type\Scheme
	 */
	public function getScheme()
	{
		return $this->data['scheme'];
	}

	/**
	 * get the URL's host value
	 * @return Type\Host
	 */
	public function getHost()
	{
		return $this->data['host'];
	}

	/**
	 * Gets the host name as array
	 *
	 * This is an extended value.
	 *
	 * The host name is split into its domain path.
	 *
	 * So it's easier to get domain, subdomain or country code
	 *
	 * @return array
	 */
	public function getHostArray()
	{
		if (!$this->data['host']) {
			return array();
		}

		return explode('.', trim($this->data['host'], '/'));
	}

	/**
	 * get the URL's port value
	 * @return Type\Port
	 */
	public function getPort()
	{
		return $this->data['port'];
	}

	/**
	 * get the URL's user and password value
	 *
	 * @return string
	 */
	public function getUser()
	{
		return $this->data['user'].':'.$this->data['pass'];
	}

	/**
	 * get the user data as array
	 *
	 * array index names:
	 * <ul>
	 * <li>user</li>
	 * <li>password</li>
	 * </ul>
	 *
	 * @return array
	 */
	public function getUserArray()
	{
		return array('user' => $this->data['user'], 'password' => $this->data['pass']);
	}

	/**
	 * get the URL's username value
	 * @return string
	 */
	public function getUserName()
	{
		return $this->data['user'];
	}

	/**
	 * get the URL's passwort value
	 * @return string
	 */
	public function getUserPassword()
	{
		return $this->data['pass'];
	}

	/**
	 * get the URL's path value
	 * @return Type\Path
	 */
	public function getPath()
	{
		return $this->data['path'];
	}

	/**
	 * Get the directory name for the given url.
	 *
	 * This is an extended value.
	 *
	 * The dirname is only provided by parse_url with the filename included. To
	 * get the dirname the last part will be cut off.
	 * If the given URL represents an directory, the parent will be seen as
	 * diraname.
	 *
	 * e.g. path is: /doc/test/akrys, dirname will be /doc/test
	 *
	 * @return string
	 */
	public function getDirname()
	{
		return dirname($this->data['path']);
	}

	/**
	 * Get the filename for the given url.
	 *
	 * This is an extended value.
	 *
	 * The basename is only provided by a complete path variable. To
	 * get the basename the last part used.
	 * If the given URL represents an directory, its own name will be seen as
	 * basename.
	 *
	 * e.g. path is: /doc/test/akrys, basename will be akrys
	 *
	 * @return string
	 */
	public function getBasename()
	{
		return basename($this->data['path']);
	}

	/**
	 * Gives the provided path as an array
	 *
	 * This is an extended value.
	 *
	 * The path value is provided as array. It provides the directory path
	 * seperate pieces.
	 *
	 * @return array
	 */
	public function getPathArray()
	{
		if (!$this->data["path"]) {
			return array();
		}
		return explode('/', trim($this->data["path"], '/'));
	}

	/**
	 * get the URL's query value
	 * @return Type\Query
	 */
	public function getQuery()
	{
		return $this->data['query'];
	}

	/**
	 * Extract get Parameter
	 *
	 * This is an extended value.
	 *
	 * The query variable provided by parse_url is split into key / value pairs.
	 * Those pairs are collected in an array. As a result, an $_GET varialbe for
	 * this URL is generated.
	 *
	 * @return array
	 */
	public function getParameter()
	{
		$out = array();
		if (!$this->data['query']) {
			return $out;
		}

		mb_parse_str($this->data['query'], $out);
		return $out;
	}

	/**
	 * get the URL's fragment value
	 * @return Type\Fragment
	 */
	public function getFragment()
	{
		return $this->data['fragment'];
	}

	/**
	 * Construct
	 * @param string $url
	 * @throws Exception\NotValidURLException
	 */
	public function __construct($url)
	{
		$this->url = $url;
		$this->data = $this->parseUrl();

		if (!$this->isValid()) {
			require_once __DIR__.'/Exception/NotValidURLException.php';
			throw new Exception\NotValidURLException($this->url);
		}

		$this->setKeys($this->data, $this->baseKeys, null);

		// @codeCoverageIgnoreStart
		if (HostFixPHP547::isEnabled()) {
			$this->data = HostFixPHP547::fixIt($this->data);
		}
		// @codeCoverageIgnoreEnd
	}

	/**
	 * parse URL
	 * @return array
	 */
	private function parseUrl()
	{
		$url = trim($this->url);
		if (empty($url)) {
			return array();
		}

		/**
		 * Until PHP 5.3.3 a warning is generated, if parse_url fails.
		 * Have a look here:
		 * https://php.net/manual/en/function.parse-url.php#refsect1-function.parse-url-changelog
		 *
		 * No one should use PHP 5.3.2 or lower in 2015 anymore.
		 * To be sure, we're hiding parse_urls possible warnings anyway.
		 */
		return @\parse_url($url);
	}

	/**
	 * URL check
	 *
	 * Checks if the URL parsed by parse_url was valid.
	 *
	 * @return boolean
	 */
	public function isValid()
	{
		return is_array($this->data) && !empty($this->data);
	}

	/**
	 * Converts the object to an string.
	 *
	 * As this class represents an URL, we can just take it as return value.
	 *
	 * So, if casted to a string this class will give you the URL that is parsed.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->url;
	}

	/**
	 * Ensures all used keys are set.
	 *
	 * This makes it easier as no validation is needed in order to reduce the
	 * amount of PHP notices.
	 *
	 * @param array $array
	 * @param array $keys
	 * @param mixed $init_value
	 */
	private function setKeys(&$array, &$keys, $init_value)
	{
		$tmp = array();
		foreach ($keys as $key) {
			if (empty($array[$key])) {
				$tmp[$key] = $init_value;
			} else {
				$tmp[$key] = $array[$key];
			}
		}
		$array = $tmp;
	}

	/**
	 * do the complete magic.
	 *
	 * Due to performance reasons, the result array of {@see \akrys\ExtendedParseUrl\parse_url()}
	 * is build here. $this->data is accessable directly and functions doesn't
	 * have to be called.
	 *
	 * @return array
	 */
	public function parse()
	{
		$return = $this->data;
		$return['dirname'] = $this->getDirName();
		$return['basename'] = $this->getBasename();
		$return['patharray'] = $this->getPathArray();
		$return['parameter'] = $this->getParameter();
		$return['hostarray'] = $this->getHostArray();
		return $return;
	}
}