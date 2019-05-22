<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rx\Scheduler;
use Rx\Observable;
use Rx\ObserverInterface;
use Rx\DisposableInterface;
use Rx\SchedulerInterface;
use Rx\Disposable\CompositeDisposable;
use Rx\Disposable\CallbackDisposable;
use Rx\Observer\AutoDetachObserver;
use Symfony\Component\Process\Process;

class ProcessObservable extends Observable {

    private $cmd;
    private $pidFile;
    private $scheduler;

    public function __construct($cmd, $pidFile = null, SchedulerInterface $scheduler = null) {
        $this->cmd = $cmd;
        $this->pidFile = $pidFile;
        $this->scheduler = $scheduler;
    }

    public function _subscribe(ObserverInterface $observer): DisposableInterface {
        $process = new Process($this->cmd);
        $process->start();

        $pid = $process->getPid();
        if ($this->pidFile) {
            file_put_contents($this->pidFile, $pid);
        }

        $disposable = new CompositeDisposable();

        $scheduler = $this->scheduler ?: Scheduler::getDefault();

        $cancelSchedulerDisposable = $scheduler->schedulePeriodic(function() use ($observer, $process, $pid, &$cancelSchedulerDisposable) {
            if ($process->isRunning()) {
                $observer->onNext($process->getOutput());
            } else {
                $cancelSchedulerDisposable->dispose();
                $observer->onCompleted();
            }
        }, 0, 200);

        $disposable->add($cancelSchedulerDisposable);
        $disposable->add(new CallbackDisposable(function() use ($process) {
            if ($this->pidFile) {
                $process->stop(10, SIGTERM);
                unlink($this->pidFile);
            }
        }));

        return $disposable;
    }

}