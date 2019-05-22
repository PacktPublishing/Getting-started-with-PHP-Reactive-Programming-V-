<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../Section02/DebugSubject.php';
require_once '../Section02/CURLObservable.php';

use Rx\Observable;
use Rx\Scheduler;

(new CURLObservable('https://example.com123'))
    ->retryWhen(function(Observable $errObs) {
        echo "retryWhen\n";
        $i = 1;
        $notificationObs = $errObs
            ->delay(1000, Scheduler::getDefault())
            ->map(function(Exception $val) use (&$i) {
                echo "attempt: $i\n";
                if ($i == 3) {
                    throw $val;
                }
                $i++;
                return $val;
            });

        return $notificationObs;
    })
    ->subscribe(new DebugSubject());
