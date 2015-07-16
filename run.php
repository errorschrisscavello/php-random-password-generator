<?php

error_reporting(E_ALL ^ E_STRICT);

require_once realpath(__DIR__) . '/index.php';

$length = 8;
$type = 'alpha_numeric';

if (isset($argv[1])) {
	$length = $argv[1];
}

if (isset($argv[2])) {
	$type = $argv[2];
}

echo "\n" . random_password($length, $type) . "\n\n";