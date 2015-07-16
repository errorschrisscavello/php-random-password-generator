<?php

/**
* Generates a random password with the given length and of the given type.
*
* @param int $length
* @param string $type 
* @return string | null
*/
function random_password($length=8, $type='alpha_numeric', $return_charset = false) {

	$lower = 'abcdefghijklmnopqrstuvwxy';
	$upper = strtoupper($lower);
	$numbers = '1234567890';
	$dash = '-';
	$underscore = '_';
	$symbols = '`~!@#$%^&*()+=[]\\{}|:";\'<>?,./';

	switch ($type) {
		case 'lower':
			$chars = $lower;
			break;
		case 'upper':
			$chars = $upper;
			break;
		case 'numeric':
			$chars = $numbers;
			break;
		case 'alpha':
			$chars = $lower . $upper;
			break;
		case 'symbol':
			$chars = $symbols . $dash . $underscore;
			break;
		case 'alpha_numeric':
			$chars = $lower . $upper . $numbers;
			break;
		case 'alpha_numeric_dash':
			$chars = $lower . $upper . $numbers . $dash;
			break;
		case 'alpha_numeric_underscore':
			$chars = $lower . $upper . $numbers . $underscore;
			break;
		case 'alpha_numeric_dash_underscore':
			$chars = $lower . $upper . $numbers . $underscore . $dash;
			break;
		case 'all':
			$chars = $lower . $upper . $numbers . $underscore . $dash . $symbols;
			break;
		default:
			return null;
	}

	$min = 0;
	$max = strlen($chars) - 1;

	if ($return_charset)
		return $chars;

	if ($length < 1 || $length > 1024)
		return null;

	$password = '';

	for ($i = 0; $i < $length; $i++) {
		$random = mt_rand($min, $max);
		$char = $chars[$random];
		$password .= $char;
	}

	return $password;
}