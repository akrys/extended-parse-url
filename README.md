# Extended parse_url
[Infos auf Deutsch](README.de.md)

This project provides additional values to the [parse_url](https://php.net/manual/en/function.parse-url.php)
function.

A list of all additional values which are generated (using
`http://example.com/path/to/test.php?test=1` as an example):

index|description|example output
:--|:--|:--
`hostarray`|hostname parsed as an array|`http://example.com`|`array(0 => 'example',	1 => 'com')`
`patharray`|path details as an array|`array(0 => 'path', 1 => 'to', 2 => 'test.php')`
`dirname`|path's diranme|`/path/to`
`basename`|path's filename|`test.php`
`parameter`|querystring formatted as array, just as `$_GET` would be in usual requests|`array('test' => '1')`

These things are easily self-written, but it's more beautiful having them at a
central place. That's why I created this project.

##Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage Example](#usage-example)
- further Information
	- [complete Reference](doc/usage.md)
	- [hostfix](doc/hostfix.md) for schemeless URL using PHP < 5.4.7

##Requirements

- [x] PHP > 5.3.0
- [x] multibyte functions have to be activated (this should be the default state)
- [x] pcre functions have to be activated (this should be the default state)

Running the tests cases requires PHP 5.3.2 or higher.

##Installation

The easiest way is an installation via [composer](http://getcomposer.org)

Just define another dependency in your ```composer.json``` file.
```json
{
	"require": {
		"akrys/extended-parse-url": "1.*"
	}
}
```

Installation or upgrades can be done in your terminal by executing
```bash
composer update
```

Include the classes to your project
```php
require_once 'vendor/autoload.php';
```

#Usage Example

```php
//You should require your path
//or
//if installed via composer: require autoload.php from your vendor-directory
require_once __DIR__.'/akrys/ExtendedParseUrl/extended_parse_url.php';

$url = 'http://example.com/path/to/test.php?p1=1&p2[]=1&p2[]=2&p3[a]=1&p3[b]=2';
//$output = parse_url($url);
$output = akrys\ExtendedParseUrl\parse_url($url);
print_r($output);
```
Output:
```
Array
(
    [scheme] => http
    [host] => example.com
    [port] =>
    [user] =>
    [pass] =>
    [path] => /path/to/test.php
    [query] => p1=1&p2[]=1&p2[]=2&p3[a]=1&p3[b]=2
    [fragment] =>
    [dirname] => /path/to
    [basename] => test.php
    [patharray] => Array
        (
            [0] => path
            [1] => to
            [2] => test.php
        )

    [parameter] => Array
        (
            [p1] => 1
            [p2] => Array
                (
                    [0] => 1
                    [1] => 2
                )

            [p3] => Array
                (
                    [a] => 1
                    [b] => 2
                )

        )

    [hostarray] => Array
        (
            [0] => example
            [1] => com
        )

)
```

This script always initializes all possible components in order to reduce php
notices. So don't worry about many ```null``` values.

