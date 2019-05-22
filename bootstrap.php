<?php

use React\EventLoop\Factory;
use Rx\Scheduler;

$loop = Factory::create();
Scheduler::setDefaultFactory(function () use ($loop) {
    return new Scheduler\EventLoopScheduler($loop);
});

register_shutdown_function(function() use ($loop) {
    $loop->run();
});