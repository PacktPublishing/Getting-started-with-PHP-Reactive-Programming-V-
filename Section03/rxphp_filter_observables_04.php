<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rx\Scheduler;
use Rx\Observable\RangeObservable;
use Rx\Observable\ConnectableObservable;

$source = new RangeObservable(0, 6, Scheduler::getImmediate());

$filteredObservable = $source
    ->map(function($val) {
        return $val ** 2;
    })
    ->filter(function($val) {
        echo "Filter: $val\n";
        return $val % 2;
    });

$connObs = new ConnectableObservable($filteredObservable);

$disposable1 = $connObs->subscribe(function($val) {
    echo "S1: ${val}\n";
});
$disposable2 = $connObs->subscribe(function($val) {
    echo "S2: ${val}\n";
});

$connObs->connect();