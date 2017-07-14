<?php

require 'signing.lib.php';

// example
echo "Example 1\n";
 
$signed = sign_dumps('foo123', 'some_random_secret');
var_dump($signed);
 
$unsigned = sign_loads($signed, 'some_random_secret');
var_dump($unsigned);
 
try {
	$unsigned = sign_loads($signed, 'some_random_secret123');
} catch (InvalidSignatureException $e) {
	echo "load with some_random_secret123 failed\n";
}
 
// example 2
echo "Example 2\n";
 
$signed = sign_dumps(['foo', 'bar'], 'some_random_secret');
var_dump($signed);
 
$unsigned = sign_loads($signed, 'some_random_secret');
var_dump($unsigned);
 
try {
	$unsigned = sign_loads($signed, 'some_random_secret123');
} catch (InvalidSignatureException $e) {
	echo "load with some_random_secret123 failed\n";
}
