<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rx\Scheduler;
use Rx\Observable\RangeObservable;
use Rx\Observable\ConnectableObservable;

$connObs = new ConnectableObservable(new RangeObservable(0, 6, Scheduler::getImmediate()));
$filteredObs = $connObs
    ->map(function($val) {
        return $val ** 2;
    })
    ->filter(function($val) {
        return $val % 2;
    });

$disposable1 = $filteredObs->subscribe(function($val) {
    echo "S1: ${val}\n";
});
$disposable2 = $filteredObs->subscribe(function($val) {
    echo "S2: ${val}\n";
});

$connObs->connect();
