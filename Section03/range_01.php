<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Section02/DebugSubject.php';

use Rx\Observable;
use Rx\Scheduler;
use Rx\Scheduler\EventLoopScheduler;
use React\EventLoop\StreamSelectLoop;

$loop = new StreamSelectLoop();
$scheduler = new EventLoopScheduler($loop);

$disposable = Observable::range(1, 5, Scheduler::getDefault())
    ->subscribe(function($val) use (&$disposable) {
        echo "$val\n";
        if ($val == 3) {
            $disposable->dispose();
        }
    });

$scheduler->start();
