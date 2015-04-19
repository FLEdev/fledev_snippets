<?php

interface LoggingInterface {
    public function logging($log);
}


class NullLogger implements LoggingInterface {

    public $logDate = '';

    public function logging($log) {
        print 'Noting to do here since null logger ' .  $log;
        // do nothing here
    }
}


class DbLogger implements LoggingInterface {

    public $logDate;

    public function __construct() {
        $this->logDate = mktime();
    }

    public function logging($log) {
        return $this->logToDatabase($log);
    }

    private function logToDatabase($log) {
        print 'Added to DB: ' . $log;
    }
}


class LoggingService {

    private $logger;

    public function __construct($newLogger) {
        $this->logger = $newLogger;
    }

    public function switchLogger($newLogger) {
        $this->logger = $newLogger;
    }

    public function getLogDate() {
        print $this->logger->logDate;
    }
}





class NullObjectTest extends \PHPUnit_Framework_TestCase {

    public function testNullObjectCreation() {
        $nullLogger = new NullLogger('');
        $persistentLogger = new DbLogger('Db entry 1');

        $loggingService = new LoggingService($nullLogger);
        // returns empty
        print  PHP_EOL . 'Null Logger: ' . PHP_EOL;
        $loggingService->getLogDate();

        $loggingService->switchLogger($persistentLogger);
        // returns date
        print  PHP_EOL . 'Persistent Logger: ' . PHP_EOL;
        $loggingService->getLogDate();
    }

    public function testDelimiter() {
        echo PHP_EOL . " ------------------" . PHP_EOL;
    }
}
