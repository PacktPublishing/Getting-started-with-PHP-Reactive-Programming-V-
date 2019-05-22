<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../Section02/DebugSubject.php';
require_once '../Section02/CURLObservable.php';

use Rx\Observable;
use Rx\Scheduler;

(new CURLObservable('https://example.com123'))
    ->retryWhen(function(Observable $errObs) {
        $i = 1;
        echo "retryWhen\n";
        $notificationObs = $errObs
            ->delay(1000, Scheduler::getDefault())
            ->map(function(Exception $val) use (&$i) {
                echo "attempt: $i\n";
                $i++;
                return $val;
            })
            ->take(3);

        return $notificationObs;
    })
    ->subscribe(new DebugSubject());
