
#How to use it: the complete guide

##Function based call
```php
$parsed = akrys\ExtendedParseUrl\parse_url($url);
```

This function call is mostly compatible to the [original function](https://php.net/manual/en/function.parse-url.php)

The [component parameter](https://php.net/manual/en/function.parse-url.php#refsect1-function.parse-url-parameters)
is not supported, because there are no constants defining the additional values.

##Object orientierted call
This interface can be used, if not all components are needed in your project:

```php
$parsed = new \akrys\ExtendedParseUrl\URL($url);

$scheme = $parsed->getScheme();
// -> http, https, ftp,...

$host = $parsed->getHost();
$hostArray = $parsed->getHostArray();

$user = $parsed->getUser();
// -> formatted string username:password
$username = $parsed->getUserName();
$password = $parsed->getUserPassword();
$userArray = $parsed->getUserArray();
// -> array('user'=>[user], 'password'=>['password'])

$port = $parsed->getPort();

$path = $parsed->getPath();
$pathArray = $parsed->getPathArray();
$dirname = $parsed->getDirname();
$basename = $parsed->getBasename();

$querystring = $parsed->getQuery();
$parameter = $parsed->getParameter();
// -> querystring as Array

$fragment = $parsed->getFragment();
// -> everything afer #
```
