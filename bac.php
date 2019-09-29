<?php

require 'lib.php';

echonl('--== Bulls and Cows ==--');
echonl('________________________');
echonl('');

$secret_filename = 'secret.txt';

$guess = $argv[1] ?? false;
if ($guess === false) {
    echo 'Generating a random number... ';

    do {
        $secret = mt_rand(1000, 9999);
    } while (!is_valid_number($secret, 4));

    echonl('Done!');

    $saved = file_put_contents($secret_filename, $secret);
    if ($saved === false) {
        error('Failed to save to ' . $secret_filename . '.');
    }
} else {
    // Read the secret from file.
    if (!file_exists($secret_filename)) {
        error('File ' . $secret_filename . ' with secret not found! Run game without args.');
    }

    $secret = file_get_contents($secret_filename);

    // Chech that guess is the same length as secret.
    if (!is_valid_number($guess, strlen($secret))) {
        error('Your guess ' . $guess . ' is invalid: it must be legth ' . strlen($secret) . ' and contain unique digits.');
    }

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

    echonl('Your guess is ' . $guess . ': bulls=' . $bulls . ', cows=' . $cows);

    if ($bulls === strlen($secret) && $cows === strlen($secret)) {
        echonl('You won! Congratulations!');
    }
}