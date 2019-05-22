<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rx\Testing\TestScheduler;
use Rx\Testing\HotObservable;
use Rx\Testing\Recorded;
use Rx\Notification\OnNextNotification;

$scheduler = new TestScheduler();

$observable = new HotObservable($scheduler, [
    new Recorded(100, new OnNextNotification(3)),
    new Recorded(150, new OnNextNotification(1)),
    new Recorded(80, new OnNextNotification(2)),
]);
$observable->subscribeCallback(function($val) {
    print("$val\n");
});

$scheduler->start();