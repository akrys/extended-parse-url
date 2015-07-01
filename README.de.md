# Extended parse_url
[Infos in English](README.md)
[parse_url](https://php.net/manual/de/function.parse-url.php) mit ein paar
zusätzlichen Werten.

Aufstellung am Beispiel: `http://example.com/path/to/test.php?test=1`

Index|Bedeutung|Beispiel
:--|:--|:--
`hostarray`|Hostname-Bestandteile als Array|`array(0 => 'example',	1 => 'com')`
`patharray`|Pfadbestandteile als Array|`array(0 => 'path', 1 => 'to', 2 => 'test.php')`
`dirname`|Dirname des Pfades|`/path/to`
`basename`|Dateiname|`test.php`
`parameter`|Querystring als Array, wie `$_GET` bei einem Request|`array('test' => '1')`

Man kann das zwar alles schnell selber schreiben, schöner ist es jedoch an einer
zentralen Stelle. Das ist übrigens auch der Grund für dieses kleine Projekt.

##Inahlt
- [Voraussetungen](#voraussetzungen)
- [Installation](#installation)
- [Anwendungsbeispiel](#anwendungsbeispiel)
- weitere Informationen
	- [komplette Nutzungsreferenz](doc/usage.de.md)
	- [HostFix](doc/hostfix.de.md) für schemalose URLs unter PHP < 5.4.7

##Voraussetzungen

- [x] PHP > 5.3.0
- [x] multibyte funktionen aktiviert (sollte normalerweise schon so voreingestellt sein)
- [x] pcre-Funktionen aktiviert (sollte normalerweise schon so voreingestellt sein)

Für Ausführung der Tests braucht es jedoch PHP 5.3.2 oder höher.

##Installation

Die einfachste Möglichkeit ist die Installation via [composer](http://getcomposer.org)

Dafür braucht man in der ```composer.json``` nur folgende Abhängigkeit definieren.
```json
{
	"require": {
		"akrys/extended-parse-url": "1.*"
	}
}
```

Die Installtion bzw. Aktualisierung passiert dann im Terminal über
```bash
composer update
```

Einbinden der Klassen im eigenen Projekt
```php
require_once 'vendor/autoload.php';
```

##Anwendungsbeispiel

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

Ausgabe:
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

Das Script initialisiert immer alle möglichen Indezes um PHP-Notices zu
vermeiden. Man darf sich also nicht darüber wundern, wenn man ein Array mit
sehr vielen ```null```-Werten bekommt.
