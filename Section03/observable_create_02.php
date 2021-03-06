<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Section02/DebugSubject.php';

use Rx\Observable;
use Rx\ObserverInterface;
use Rx\Disposable\CallbackDisposable;

$source = Observable::create(function(ObserverInterface $obs) {
    echo "Observable::create\n";
    $obs->onNext(1);
    $obs->onNext('Hello, World!');
    $obs->onNext(2);
    $obs->onCompleted();

    return new CallbackDisposable(function() {
        echo "disposed\n";
    });
});

$source->subscribe(new DebugSubject());
$source->subscribe(new DebugSubject());
