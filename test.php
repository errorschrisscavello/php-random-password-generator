<?php

error_reporting(E_ALL ^ E_STRICT);

require_once realpath(__DIR__) . '/index.php';

function heading($text)
{
	echo "----\n";
	echo $text . "\n";
}

function test($length=8, $type='alpha_numeric', $iterations=10)
{
	for ($i = 0; $i < $iterations; $i++) {
		$password = random_password($length, $type);
		yield $password;
	}
}

function run($length=8, $type='alpha_numeric') {
	heading("Testing default parameters: length=" . $length . ", type=" . $type);

	echo "Running...\n\n";
	foreach (test($length, $type) as $result) {
		if ($result)
			echo $result . "\n";
	}
	echo "\nDone.\n\n";
}

function real_probability($length, $type) {
	$charset_length = strlen(random_password($length, $type, true));
	$exponent = $length;
	$probability = pow($charset_length, $exponent);
	//heading('Real probability for length= ' . $length . ', type=' . $type);
	//printf("Exponent: %d\n", $exponent);
	$probability = (is_infinite($probability)) ? 'Infinite' : '1 / ' .$probability;
	printf("Real probability: %s\n", $probability);
	printf("Charset length: %d\n", $charset_length);
}

function real_probability_all($length) {
	real_probability($length, 'lower');
	real_probability($length, 'upper');
	real_probability($length, 'alpha');
	real_probability($length, 'numeric');
	real_probability($length, 'symbol');
	real_probability($length, 'alpha_numeric');
	real_probability($length, 'alpha_numeric_dash');
	real_probability($length, 'alpha_numeric_underscore');
	real_probability($length, 'alpha_numeric_dash_underscore');
	real_probability($length, 'all');
}

function probability($length=8, $type='alpha_numeric', $max=1000000) {
	$result = random_password($length, $type);
	$iterations = 0;
	while (true) {
		$next = random_password($length, $type);
		//printf("Probability progress: %f%s\r", $iterations / $max, '%');
		if ($result === $next)
			break;
		if ($iterations == $max)
			break;
		$iterations++;
	}
	$probability = ($iterations == $max) ? '+' . $max : '1 / ' . $iterations;
	//printf("Probability: %s\n", $probability);
	return $iterations;
}

function average_probability($length=8, $type='alpha_numeric', $tests=100, $max=1000000) {
	heading('Probability for length= ' . $length . ', type=' . $type);

	$iterations = 0;
	$low = INF;
	$high = 0;
	for ($i = 0; $i < $tests; $i++) {
		printf("Running test %d of %d\r", $i, $tests);
		//printf("Test progress: %f%s\r", $i / $tests, '%');
		$result = probability($length, $type, $max);
		$low = ($result < $low) ? $result : $low;
		$high = ($result > $high) ? $result : $high;
		$iterations += $result;
		//printf("Iteration count: %d\n", $iterations);
	}
	$average = $iterations / $tests;
	printf("Iteration range: %d - %d\n", $low, $high);
	printf("Average probability tests_run[%d] max_iterations[%d]: 1 / %d\n", $tests, $max, $average);
}

function average_probability_all($length) {
	average_probability($length, 'lower');
	average_probability($length, 'upper');
	average_probability($length, 'alpha');
	average_probability($length, 'numeric');
	average_probability($length, 'symbol');
	average_probability($length, 'alpha_numeric');
	average_probability($length, 'alpha_numeric_dash');
	average_probability($length, 'alpha_numeric_underscore');
	average_probability($length, 'alpha_numeric_dash_underscore');
	average_probability($length, 'all');
}

function probability_compare_all($length) {
	average_probability($length, 'lower');
	real_probability($length, 'lower');
	average_probability($length, 'upper');
	real_probability($length, 'upper');
	average_probability($length, 'alpha');
	real_probability($length, 'alpha');
	average_probability($length, 'numeric');
	real_probability($length, 'numeric');
	average_probability($length, 'symbol');
	real_probability($length, 'symbol');
	average_probability($length, 'alpha_numeric');
	real_probability($length, 'alpha_numeric');
	average_probability($length, 'alpha_numeric_dash');
	real_probability($length, 'alpha_numeric_dash');
	average_probability($length, 'alpha_numeric_underscore');
	real_probability($length, 'alpha_numeric_underscore');
	average_probability($length, 'alpha_numeric_dash_underscore');
	real_probability($length, 'alpha_numeric_dash_underscore');
	average_probability($length, 'all');
	real_probability($length, 'all');
}

//ob_start();

printf("\n\n%s\n\n", random_password(0, 'all', true));

run();
run(0);
run(1234567890);
run(32);
run(8, 'foo');
run(8, 'lower');
run(8, 'upper');
run(8, 'alpha');
run(8, 'numeric');
run(8, 'symbol');
run(8, 'alpha_numeric');
run(8, 'alpha_numeric_dash');
run(8, 'alpha_numeric_underscore');
run(8, 'alpha_numeric_dash_underscore');
run(8, 'all');

// ----

// for ($i = 1; $i < 1025; $i++) {
// 	real_probability_all($i);
// }

// ----

// for ($i = 1; $i < 5; $i++) {
// 	average_probability_all($i);
// }

for ($i = 1; $i < 4; $i++) {
	probability_compare_all($i);
}

//file_put_contents(realpath(__DIR__) . '/output.txt', ob_get_clean());