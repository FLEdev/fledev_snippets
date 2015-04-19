<?php

interface Logger{
  public function logEvent($type, $message);
  public function getEventByType($typ);
}

class DbLogger implements Logger {

  private $dbMocker = array();

  public function insertIntoDb($newEvent) {
    // Since we don't have an DB connection we insert it into a array
    $this->dbMocker[$newEvent[0]][] = $newEvent;
  }

  public function logEvent($type, $message) {
    $this->insertIntoDb(array($type, $message));
  }

  public function getEventByType($type) {
    return $this->dbMocker[$type];
  }
}

class FileLogger implements Logger {
  private $storageMock = array();

  public function storeEvent($newEvent) {
    // Since we don't have an DB connection we insert it into a array
    $this->storageMock[$newEvent[0]][] = $newEvent;
  }

  public function logEvent($type, $message) {
    $this->storeEvent(array($type, $message));
  }

  public function getEventByType($type) {
    return $this->storageMock[$type];
  }
}


class SystemLog {

  public $log;
  // @param Logger $newLog
  public function __construct(Logger $newLog) {
    $this->log = $newLog;
  }

  public function log($type, $message) {
    $this->log->logEvent($type, $message);
  }

  public function getLog($type) {
    return $this->log->getEventByType($type);
  }
}


class DependencyInjectionTest extends \PHPunit_Framework_Testcase {

  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }

  public function testLoggerInsertFile() {
    $newEmailLogger = new FileLogger();
    $systemLogger = new SystemLog($newEmailLogger);

    $systemLogger->log('status', 'Processor running on 32% usage.');
    $systemLogger->log('status', 'Processor running on 95% usage.');
    $systemLogger->log('error', 'Out of memory.');
    $statusEntries = $systemLogger->getLog('status');
    print 'Entries found: ' . count($statusEntries) . PHP_EOL;
    $this->assertEquals(count($statusEntries), 2);
  }

  public function testLoggerInsertDb() {
    $newDbLogger = new DbLogger();
    $systemLogger = new SystemLog($newDbLogger);

    $systemLogger->log('status', 'Processor running on 45% usage.');
    $systemLogger->log('status', 'Processor running on 60% usage.');
    $systemLogger->log('status', 'Processor running on 90% usage.');
    $systemLogger->log('error', 'Out of memory.');
    $errorEntries = $systemLogger->getLog('error');
    print 'Entries found: ' . count($errorEntries) . PHP_EOL;
    $this->assertEquals(count($errorEntries), 1);
  }
}