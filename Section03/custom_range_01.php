<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Section02/DebugSubject.php';

use Rx\Observable;
use Rx\ObserverInterface;
use Rx\DisposableInterface;
use Rx\Scheduler;
use Rx\Scheduler\EventLoopScheduler;
use React\EventLoop\StreamSelectLoop;

class CustomRangeObservable extends Observable
{

    private $min;
    private $max;
    private $sched;

    public function __construct($min, $max, $sched = null)
    {
        $this->min = $min;
        $this->max = $max;
        $this->sched = $sched;
    }

    public function _subscribe(ObserverInterface $observer): 		       		DisposableInterface
    {
        $sched = null === $this->sched ? Scheduler::getImmediate() : 
	$this->sched;

        return $sched->schedule(function() use ($observer) {
            for ($i = $this->min; $i <= $this->max; $i++) {
                $observer->onNext($i);
            }

            $observer->onCompleted();
        });
    }
}

$loop = new StreamSelectLoop();
$scheduler = new EventLoopScheduler($loop);

$disposable = (new CustomRangeObservable(1, 5, $scheduler))
    ->subscribe(function($val) use (&$disposable) {
        echo "$val\n";
        if ($val == 3) {
            $disposable->dispose();
        }
    }, null, null, $scheduler);

    $scheduler->start();
