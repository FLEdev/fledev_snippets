<?php

interface GetAtmData {
  public function getAtmState();
  public function getCashInAtm();
}

class AtmMachine implements GetAtmData {
  public $atmState;
  public $cashAmount;

  public function __construct() {
    // Daily fix ATM fill up
    $this->cashAmount = 400;
  }

  public function retrieveCash($sum) {
    $this->cashAmount -= ($this->cashAmount-$sum > 0) ? $sum : 0;
  }

  public function getAtmState() {
    return $this->atmState;
  }

  public function getCashInAtm() {
    return $this->cashAmount;
  }

  public function transferMoney() {
  // You don't want that this will be accessible to others.
  }
  public function returnMoneyWithoutAuthentication() {
    // You don't want that this will be accessible to others.
  }
}

class AtmMachineProxy implements GetAtmData {
  public $atmMachine;

  public function __construct() {
    $this->atmMachine = new AtmMachine();
  }

  public function insertCard() {
    $this->atmMachine->atmState = 'Transaction started';
  }

  public function retrieveCash($sum) {
    $this->atmMachine->atmState = 'Providing ' . $sum . '$';
    $this->atmMachine->retrieveCash($sum);
    return 'Trying to retrieve: ' .  $sum . '$' . PHP_EOL;
  }

  public function getAtmState() {
    return $this->atmMachine->getAtmState();
  }

  public function getCashInAtm() {
    return 'Balance in ATM: ' . $this->atmMachine->getCashInAtm() . '$';
  }
}

class ProxyTest extends \PHPunit_Framework_Testcase {

  public static function setUpBeforeClass() {
  }

  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }

  public function testAtmMachine() {
    $AtmDevice = new AtmMachineProxy();
    $AtmDevice->insertCard();
    print $AtmDevice->getAtmState() . PHP_EOL;
    print $AtmDevice->retrieveCash(200);
    print $AtmDevice->getCashInAtm() . PHP_EOL;
    print $AtmDevice->getAtmState() . PHP_EOL;
    print $AtmDevice->retrieveCash(200);
    print $AtmDevice->retrieveCash(100);
    print $AtmDevice->getCashInAtm() . PHP_EOL;
  }
}