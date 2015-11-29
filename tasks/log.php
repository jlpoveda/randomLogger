<?php
require_once __DIR__.'/../vendor/autoload.php';

use RandomLogger\Request\RandomLoggerRequest;
use RandomLogger\Service\RandomLoggerService;

$sample = isset($argv[1])?$argv[1]:null;

try {
    $logger = new RandomLoggerService(new RandomLoggerRequest($sample));
    $info = $logger->doLog();
    echo $info . PHP_EOL;
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage() . PHP_EOL;
}

