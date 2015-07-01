#HostFix
[parse_url](https://php.net/manual/de/function.parse-url.php#refsect1-function.parse-url-changelog)
kann vor PHP 5.4.7 nicht mit der schemalosen URLs umgehen.

Beispiel: `//example.com`

Der Hostname wird in dem Fall als Pfad erkannt. Das ist heute nicht mehr immer
richtig und auch nicht immer gewünscht. Um solche URLs dennoch richtig parsen
lassen zu können, ist in die Klasse ein "HostFix" eingebaut. Dieser ist aber
standardmäßig deaktiviert, da auf die Funktionalität von [parse_url](https://php.net/manual/de/function.parse-url.php#refsect1-function.parse-url-changelog)
aufgebaut werden soll, und keine PHP-Funktionsweisen geändert werden sollten.

Man kann ihn bei Bedarf aber einschalten. Dazu bedient man sich den statischen
Methoden `HostFixPHP547::enable()` und `HostFixPHP547::disable()` der zentralen
URL-Klasse. Der aktuelle Status lässt sich über die Methode
`HostFixPHP547::isEnabled()` abfragen.

Eine Aktivierung bzw. Deaktivierung bleibt solange erhalten, bis der Status
geändert wird. Es kann also auch ganz leicht für das ganze Projekt eingeschaltet
werden.

Eine Aktivierung in PHP >= 5.4.7 ist nicht nötig, weil es keinen Fall geben
sollte, wo eine Reparatur notwendig wäre.

Pratkische Einsatzmöglichkeit:
```php
if(\akrys\ExtendedParseUrl\HostFixPHP547::isEnabled()){
	\akrys\ExtendedParseUrl\HostFixPHP547::disable();
	$parsed = akrys\ExtendedParseUrl\parse_url($url); //Hostfix inaktiv
	$parsed = akrys\ExtendedParseUrl\parse_url($url2); //Hostfix inaktiv
} else {
	\akrys\ExtendedParseUrl\HostFixPHP547::enable();
	$parsed = akrys\ExtendedParseUrl\parse_url($url); //Hostfix aktiv
	$parsed = akrys\ExtendedParseUrl\parse_url($url2); //Hostfix aktiv

	\akrys\ExtendedParseUrl\HostFixPHP547::disable();
	$parsed = akrys\ExtendedParseUrl\parse_url($url3); //Hostfix inaktiv
}

//da der HostFix abgeschaltet wird, wenn er aktiv war (if-Zweig)
//und nur kurz aktiviert wurde, bevor er wieder deaktivert wurde (else-Zweig),
//ist er nun auf jeden Fall inaktiv.
$parsed = akrys\ExtendedParseUrl\parse_url($url4); //Hostfix inaktiv

```

