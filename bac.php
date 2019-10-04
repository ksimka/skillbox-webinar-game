<?php

require 'lib.php';

echonl('--== Bulls and Cows ==--');
echonl('________________________');
echonl('');

echo 'Generating a random number... ';

do {
    $secret = mt_rand(1000, 9999);
} while (!is_valid_number($secret, 4));

echonl('Done!');

echonl('Enter your guess: ');

$try = 1;
while (true) {
    $guess = readline($try .') ');

    // Check that guess is the same length as secret.
    if (!is_valid_number($guess, strlen($secret))) {
        echonl('Your guess ' . $guess . ' is invalid: it must be legth ' . strlen($secret) . ' and contain unique digits.');
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

    if ($bulls === strlen($secret) && $cows === strlen($secret)) {
        echonl(col_green('You won! Congratulations!'));
        exit(0);
    }
}