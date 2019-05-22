<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../Section02/DebugSubject.php';

$count = 0;

Rx\Observable::range(1, 6)
    ->map(function() use (&$count) {
        if (++$count == 3) {
            throw new \Exception('error');
        }
        return $count;
    })
    ->retry(3)
    ->takeWhile(function($val) {
        return $val <= 6;
    })
    ->subscribe(new DebugSubject());
