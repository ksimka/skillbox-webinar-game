<?php

function echonl(string $s) : void {
    echo $s . PHP_EOL;
}

function error(string $s) : void {
    echonl($s);
    exit(1);
}