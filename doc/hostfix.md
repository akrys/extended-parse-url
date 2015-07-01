#HostFix
[parse_url](https://php.net/manual/en/function.parse-url.php#refsect1-function.parse-url-changelog)
isn't able to deal with schemeless URLs before PHP version 5.4.7.

Example: `//example.com`

In this case the hostname would be identfied as path.

As this is not always the expected behavior, there is a hostfix code can be
enabled or disabled, just as needed. This can be done using one of the static
methods `HostFixPHP547::isEnabled()` or `HostFixPHP547::disable()`. The current
state can be found out by using `HostFixPHP547::isEnabled()`.

The setting is remembered across the entire runtime. (as long as it isn't
changed by calling one of the settings changing methods)

An activation in PHP >= 5.4.7 is not necessary as there isn't anything to repair
in PHP >= 5.4.7

Possible scenarios:
```php
if(\akrys\ExtendedParseUrl\HostFixPHP547::isEnabled()){
	\akrys\ExtendedParseUrl\HostFixPHP547::disable();
	$parsed = akrys\ExtendedParseUrl\parse_url($url); //Hostfix inactive
} else {
	\akrys\ExtendedParseUrl\HostFixPHP547::enableHostFixPHP547();
	$parsed = akrys\ExtendedParseUrl\parse_url($url); //Hostfix activ
	$parsed = akrys\ExtendedParseUrl\parse_url($url2); //Hostfix activ

	\akrys\ExtendedParseUrl\HostFixPHP547::disable();
	$parsed = akrys\ExtendedParseUrl\parse_url($url3); //Hostfix inactiv
}

//as the host fix is disabled in the if block and
//temporary enabled in the else block, it's now definitely deactivated
$parsed = akrys\ExtendedParseUrl\parse_url($url4); //Hostfix inactive
```

