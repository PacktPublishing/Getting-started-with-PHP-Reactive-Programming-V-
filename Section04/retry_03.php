<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../Chapter 02/DebugSubject.php';

$count = 0;

Rx\Observable::interval(1000)
    ->map(function () use (&$count) {
        if (++$count % 2 == 0) {
            throw new \Exception('$val % 2');
        } else {
            return $count;
        }
    })
    ->do(new DebugSubject())
    ->retry(3)
    ->subscribe(new DebugSubject());