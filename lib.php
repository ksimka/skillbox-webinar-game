<?php

function echonl(string $s) : void {
    echo $s . PHP_EOL;
}

function error(string $s) : void {
    echonl(col_red($s));
    exit(1);
}

function is_valid_number(string $number, int $length) : bool {
    if (strlen($number) !== $length) {
        return false;
    }

    $unique_chars = array_unique(str_split($number));
    if (count($unique_chars) < $length) {
        return false;
    }

    return true;
}

function col_red(string $message) : string {
    return "\e[0;31m{$message}\e[0m";
}

function col_green(string $message) : string {
    return "\e[0;32m{$message}\e[0m";
}

function col_yellow(string $message) : string {
    return "\e[0;33m{$message}\e[0m";
}

function col_blue(string $message) : string {
    return "\e[0;34m{$message}\e[0m";
}

function write_log(bool $enabled, string $log_name, string $message) : void {
    if (!$enabled) {
        return;
    }

    $written = file_put_contents('logs/' . $log_name, $message, FILE_APPEND);
    if ($written === false) {
        error('Failed to write to log file ' . $log_name);
    }
}