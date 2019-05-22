<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/DebugSubject.php';
require_once __DIR__ . '/JSONDecodeOperator.php';
require_once __DIR__ . '/CURLObservable.php';

// https://api.reddit.com/r/nosleep/hot?limit=5
$observable = new CurlObservable('https://api.stackexchange.com/2.2/questions?order=desc&sort=creation&tagged=functional-programming&site=stackoverflow');

$observable
    ->filter(function($value) {
        return is_string($value);
    })
    ->lift(function() {
        return new JSONDecodeOperator();
    })
    ->subscribe(new DebugSubject(null, 128));



