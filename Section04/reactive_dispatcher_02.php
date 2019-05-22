<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Section02/DebugSubject.php';
require_once __DIR__ . '/ReactiveEventDispatcher.php';
require_once __DIR__ . '/MyEvent.php';

use Symfony\Component\EventDispatcher\Event;
use Rx\Observable;
use Rx\Observer\CallbackObserver;

$dispatcher = new ReactiveEventDispatcher();

$dispatcher->addListener('my.action', function(Event $event) {
    echo "Listener #1\n";
});
$dispatcher->addListener('my.action', new CallbackObserver(function($event) {
    echo "Listener #2\n";
}), 1);

$dispatcher->dispatch('my.action', new MyEvent());
