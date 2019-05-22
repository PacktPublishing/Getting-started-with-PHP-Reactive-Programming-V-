<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../Section02/DebugSubject.php';
require_once '../Section02/CURLObservable.php';

use Rx\Observable;
use Rx\Scheduler;

(new CURLObservable('https://example.com123'))
    ->retryWhen(function(Observable $errObs) {
        $notificationObs = $errObs
            ->delay(1000, Scheduler::getDefault())
            ->map(function() {
                echo "onNext\n";
                return true;
            });
        return $notificationObs;
    })
    ->subscribe(new DebugSubject());

