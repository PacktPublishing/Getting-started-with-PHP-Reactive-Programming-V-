<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Section02/DebugSubject.php';

use Rx\Observable;
use Rx\Scheduler;
use Rx\ObserverInterface;

$source = Observable::range(0, rand(1, 10), Scheduler::getImmediate());

$source->subscribe(new DebugSubject('#1'));
$source->subscribe(new DebugSubject('#2'));
