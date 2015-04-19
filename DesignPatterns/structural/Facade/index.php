<?php

class CarModel {
  public $model;
  public function __construct($newModel) {
    $this->model = $newModel;
  }
  public function getCarModel() {
    return $this->model;
  }
}

class CarChassis {
  public function setCarChassis() {
    return 'The Chassis of the car is Created.';
  }
}

class CarBody {
  public function setCarBody() {
    return 'The Body of the car is Made.';
  }
}

class CarEngine {
  public function setCarEngine() {
    return 'The Engine of the car is Build.';
  }
}

class CarFacade {

  public $carModel;
  public $carEngine;
  public $carChassis;
  public $carBody;

  public function __construct($newModel) {
    $this->carModel = new CarModel($newModel);
    $this->carChassis = new CarChassis();
    $this->carBody = new CarBody();
    $this->carEngine = new CarEngine();
  }

  public function createCompleteCar() {
    print 'Starting to create a Car' . PHP_EOL;
    print 'Model ' . $this->carModel->getCarModel() . PHP_EOL;
    print $this->carChassis->setCarChassis() . PHP_EOL;
    print $this->carBody->setCarBody() . PHP_EOL;
    print $this->carEngine->setCarEngine() . PHP_EOL;
  }

}

class FacadeTest extends \PHPunit_Framework_Testcase {

  public static function setUpBeforeClass() {
  }

  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }

  public function testCarCreation() {
    $carCreator = new CarFacade('Sedan');
    $carCreator->createCompleteCar();
  }
}