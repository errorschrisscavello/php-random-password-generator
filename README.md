# PHP Random password and string generator

Generates a random password with the given length and of the given type.

## Usage:

	$password = random_password();
	$password = random_password(32);
	$password = random_password(8, 'lower');
	$password = random_password(8, 'upper');
	$password = random_password(8, 'alpha');
	$password = random_password(8, 'numeric');
	$password = random_password(8, 'symbol');
	$password = random_password(8, 'alpha_numeric');
	$password = random_password(8, 'alpha_numeric_dash');
	$password = random_password(8, 'alpha_numeric_underscore');
	$password = random_password(8, 'alpha_numeric_dash_underscore');
	$password = random_password(8, 'all');

#### Returns `null` if the `$length` is > 1024 or < 1

	$password = random_password(0);
	$password = random_password(1234567890);

#### Returns `null` if the `$type` is invalid

	$password = random_password(8, 'foo');

##### Curious to see the character set being used? Set `$type` to the desired type and the 3rd parameter `$return_charset` to true. The first parameter `$length` will be ignored.

	$charset = random_password(0, 'all', true);
	#=> abcdefghijklmnopqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXY1234567890_-`~!@#$%^&*()+=[]\{}|:";'<>?,./