<?php

/**
 * Datei für ...
 *
 * @since         Programmversion 1.0
 * @author        akrys
 */
// @codeCoverageIgnoreStart
require_once __DIR__.'/akrys/ExtendedParseUrl/extended_parse_url.php';

$url='http://example.com/path/to/test.php?p1=1&p2[]=1&p2[]=2&p3[a]=1&p3[b]=2';
print $url."\n";
print_r(akrys\ExtendedParseUrl\parse_url($url));

// @codeCoverageIgnoreEnd
?>