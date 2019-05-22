<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/JSONDecodeOperator.php';
//require_once __DIR__ . '/JSONDecodeOperator2.php';
require_once __DIR__ . '/DebugSubject.php';

use Rx\Observable;

Observable::just('{"value":42}')
    ->JSONDecode()
    ->subscribe(new DebugSubject());
