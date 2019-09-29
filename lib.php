<?php

function echonl(string $s) : void {
    echo $s . PHP_EOL;
}

function error(string $s) : void {
    echonl($s);
    exit(1);
}

function is_valid_number(int $number, int $length) : bool {
    if (strlen((string)$number) !== $length) {
        return false;
    }

    $unique_chars = array_unique(str_split($number));
    if (count($unique_chars) < $length) {
        return false;
    }

    return true;
}