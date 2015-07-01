#Nutzung

##Funktionaler Aufruf
```php
$parsed = akrys\ExtendedParseUrl\parse_url($url);
```

Dieser ist zum großen Teil kompatibel zu [Originalfunktion](https://php.net/manual/de/function.parse-url.php)

Einzige Einschränkung: der [component Parameter](https://php.net/manual/de/function.parse-url.php#refsect1-function.parse-url-parameters)
wird nicht unterstützt, da es keine Konstanten für die Zusatz-Werte gibt.

##Objekt-Orientierter Aufruf
Wird nur ein ganz bestimmter Wert des Ergebnisses benötigt, so kann man auch
braucht man nicht alle unbedingt alle Werte errechnen zu lassen:

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

