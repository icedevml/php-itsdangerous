<?php

require 'vendor/autoload.php';

use IceDev\itsdangerous\Signing;

// example
$s = new Signing('some_random_secret');
$bad_s = new Signing('other_bad_secret');

echo "Example 1\n";
 
$signed = $s->dump('foo123');
var_dump($signed);
 
$unsigned = $s->load($signed);
var_dump($unsigned);
 
try {
	$unsigned = $bad_s->load($signed);
} catch (InvalidSignatureException $e) {
	echo "load failed\n";
}
 
// example 2
echo "Example 2\n";
 
$signed = $s->dump(['foo', 'bar']);
var_dump($signed);
 
$unsigned = $s->load($signed);
var_dump($unsigned);
 
try {
	$unsigned = $bad_s->load($signed);
} catch (InvalidSignatureException $e) {
	echo "load failed\n";
}
