<?php

interface AtmStateInterface {
  public function insertCard();
  public function ejectCard();
  public function insertPin($pinEntered);
  public function requestCash($cashToWithdraw);
}


class AtmMachine implements AtmStateInterface {
  
  // The following states has to have object implementations
  // which are dealing with the various states
  // @type AtmStageInterface
  public $hasCard;
  // @type AtmStageInterface
  public $noCard;
  // @type AtmStageInterface
  public $hasCorrectPin;
  // @type AtmStageInterface
  public $atmOutOfMoney;
  
  // @type AtmStageInterface
  public $atmState;
  
  // @type boolean
  public $correctPin = false;
  
  // @type int
  public $atmCashAmount;
  
  public function __construct() {

    $this->hasCard = new HasCard($this);
    $this->noCard = new NoCard($this);
    $this->hasCorrectPin = new HasCorrectPin($this);
    $this->atmOutOfMoney = new AtmOutOfMoney($this);

    // The default state setting.
    // Later on this states will be changed via $atmState change.
    // regardin deafult sate, the cash state should be checked
    $this->atmState = $this->noCard;
    
    $this->atmCashAmount = 2000;
  }
  
  public function setAtmState($newAtmState) {
    $this->atmState = $newAtmState;
  }
  // @param int $pinEntered
  public function insertPin($pinEntered){
    $this->atmState->insertPin($pinEntered);
  }
  
  public function insertCard() {
    $this->atmState->insertCard();
  }

  public function ejectCard() {
    $this->atmState->ejectCard();
  }

  // @param int $cashToWithdraw
  public function requestCash($cashToWithdraw) {
    $this->atmState->requestCash($cashToWithdraw);
  }
  
  public function getHasCardState() { return $this->hasCard; }
  public function getNoCardState() { return $this->noCard; }
  public function getHasCorrectPinState() { return $this->hasCorrectPin; }
  // this state is to use only if there is no cash in the ATM - not if the amount is not enough
  public function getAtmOutOfMoneyState() { return $this->atmOutOfMoney; }
}

// State implementation:
// ----------------------------------------------------------

class NoCard implements AtmStateInterface {
  // @type AtmMachine
  public $atmMachine;
  
  public function __construct($newAtmMachine) {
    $this->atmMachine = $newAtmMachine;
    if($this->atmMachine->atmCashAmount <= 0) {
      $this->atmMachine->setAtmState($this->atmMachine->getAtmOutOfMoneyState());
    }
  }

  public function insertCard() {
    print 'Enter your pin:' . "\n";
    $this->atmMachine->setAtmState($this->atmMachine->getHasCardState());
  }
  
  public function ejectCard() {
    print 'Please insert your card first.' . "\n";
  }
  
  // @param int $pinEntered
  public function insertPin($pinEntered) {
    print 'Please insert your card first.' . "\n";
  }
  
  // @param int $cashToWithdraw
  public function requestCash($cashToWithdraw) {
    print 'Please insert your card first.' . "\n";
  }
}


class HasCard implements AtmStateInterface {
  // @type AtmMachine
  public $atmMachine;
  
  public function __construct($newAtmMachine) {
    $this->atmMachine = $newAtmMachine;
  }
  public function insertCard() {
    print 'You can insert only one card at a time.' . "\n";
  }
  
  public function ejectCard() {
    print 'Your card is returned.' . "\n";
    $this->atmMachine->setAtmState($this->atmMachine->getNoCardState());
  }
  
  // @param int $pinEntered
  public function insertPin($pinEntered) {
    if ($pinEntered == '9876') {
      print 'The pin you entered is correct.' . "\n";
      $this->atmMachine->correctPin = true;
      $this->atmMachine->setAtmState($this->atmMachine->getHasCorrectPinState());
    } else {
      print 'Incorrect pin entered.' . "\n";
      $this->atmMachine->correctPin = false;
      $this->atmMachine->setAtmState($this->atmMachine->getNoCardState());
    }
  }

  // @param int $cashToWithdraw
  public function requestCash($cashToWithdraw) {
    print 'Please insert your card first.' . "\n";
  }
}

class HasCorrectPin implements AtmStateInterface {
  // @type AtmMachine
  public $atmMachine;

  public function __construct($newAtmMachine) {
    $this->atmMachine = $newAtmMachine;
  }
  public function insertCard() {
    print 'You already entered a card.' . "\n";
  }

  public function ejectCard() {
    print 'Your card is returned.' . "\n";
    $this->atmMachine->setAtmState($this->atmMachine->getNoCardState());
  }

  // @param int $pinEntered
  public function insertPin($pinEntered) {
    print 'You already entered a correct pin.' . "\n";
  }

  // @param int $cashToWithdraw
  public function requestCash($cashToWithdraw) {
    if($cashToWithdraw > $this->atmMachine->atmCashAmount) {
      print 'The requested amount is not available.';
      print 'The requested amount is not available.' . "\n";
    } else {
      print $cashToWithdraw .' is provided to you.' . "\n";
    }
    $this->atmMachine->setAtmState($this->atmMachine->getNoCardState());
  }
}

class AtmOutOfMoney implements AtmStateInterface {
  // @type AtmMachine
  public $atmMachine;

  public function __construct($newAtmMachine) {
    $this->atmMachine = $newAtmMachine;
  }
  public function insertCard() {
    print 'There is no money to extract available.' . "\n";
    print 'Yor card will be rejected' . "\n";
    $this->atmMachine->setAtmState($this->atmMachine->getNoCardState());
  }

  public function ejectCard() {
    print 'There is no money to extract available.' . "\n";
    print 'Nothing to return since no card inserted.' . "\n";
  }

  // @param int $pinEntered
  public function insertPin($pinEntered) {
    print 'There is no money to extract available.' . "\n";
  }

  // @param int $cashToWithdraw
  public function requestCash($cashToWithdraw) {
    print 'There is no money to extract available.' . "\n";
  }
}
// ----------------------------------------------------------

class StateTest extends \PHPunit_Framework_Testcase {
  
  public function testAtm() {
    $atmMachine = new AtmMachine();
    
    $atmMachine->insertCard();
    $atmMachine->ejectCard();
    $atmMachine->requestCash(intval(100));
    echo "\n ------------------ \n";
    $atmMachine->insertCard();
    $atmMachine->insertPin(9876);
    $atmMachine->requestCash(200);
    echo "\n ------------------ \n";
    $atmMachine->insertCard();
    $atmMachine->insertPin(9876);
    $atmMachine->ejectCard();
    
  }
}


