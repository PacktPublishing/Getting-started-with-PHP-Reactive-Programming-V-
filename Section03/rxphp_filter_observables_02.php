<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rx\Scheduler;
use Rx\Observable\RangeObservable;
use Rx\Observable\ConnectableObservable;
use Rx\Subject\Subject;

$source = new RangeObservable(0, 6, Scheduler::getImmediate());
$filteredObservable = $source
    ->map(function($val) {
        return $val ** 2;
    })
    ->filter(function($val) {
        return $val % 2;
    });

$disposable1 = $filteredObservable->subscribe(function($val) {
    echo "S1: ${val}\n";
});
$disposable2 = $filteredObservable->subscribe(function($val) {
    echo "S2: ${val}\n";
});

