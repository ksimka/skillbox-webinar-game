<?php

require 'lib.php';

$options = getopt('', ['length:', 'tries:', 'log'], $optind); // https://www.php.net/manual/ru/function.getopt.php

$secret_length = $options['length'] ?? 4;
if ($secret_length < 3 || $secret_length > 6) {
    echonl(col_red('Invalid length, must be between 3 and 6'));
    exit(1);
}

$tries = $options['tries'] ?? 100;

$log_name = date('YmdHis') . '.log';
$log_enabled = isset($options['log']);
var_dump($options, $log_enabled);

$base = 10 ** ($secret_length - 1);

echonl('--== Bulls and Cows ==--');
echonl('________________________');
echonl('');

echo 'Generating a random number... ';

do {
    $secret = mt_rand($base, 10 * $base - 1);
} while (!is_valid_number($secret, $secret_length));

echonl('Done!');

echonl('Enter your guess: ');

$try = 1;
while (true) {
    $guess = readline($try .') ');

    write_log($log_enabled, $log_name, $guess);

    if (empty($guess)) {
        echonl(col_red('Resigned! The secret was ' . $secret));
        write_log($log_enabled, $log_name, "\nresigned, secret - $guess");
        exit(0);
    }

    // Check that guess is the same length as secret.
    if (!is_valid_number($guess, $secret_length)) {
        echonl('Your guess ' . $guess . ' is invalid: it must be legth ' . $secret_length . ' and contain unique digits.');
        write_log($log_enabled, $log_name, " - invalid\n");
        continue;
    }

    $try++;

    $bulls = 0;
    $cows = 0;

    foreach (str_split($secret) as $si => $secret_char) {
        foreach (str_split($guess) as $gi => $guess_char) {
            if ($secret_char === $guess_char) {
                $bulls++;

                if ($si === $gi) {
                    $cows++;
                }
            }
        }
    }

    echonl(col_yellow($bulls) . ' ' . col_blue($cows));
    write_log($log_enabled, $log_name, " - $bulls $cows\n");

    if ($bulls === strlen($secret) && $cows === strlen($secret)) {
        echonl(col_green('You won! Congratulations!'));
        write_log($log_enabled, $log_name, "win");
        exit(0);
    }

    if ($try > $tries) {
        echonl(col_red('That was the last try, you lose! The secret was ' . $secret));
        write_log($log_enabled, $log_name, "out of tries, secret - $guess");
        exit(1);
    }
}