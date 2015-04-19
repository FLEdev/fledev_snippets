<?php

interface CarPlan {
  public function setCarChassis($newChasis);
  public function setCarDoors($newDoors);
  public function setCarEngine($newEngine);
}

class Car implements CarPlan {
  
  private $chassis;
  private $doors;
  private $engine;
  
  public function setCarChassis($newChasis) {
    $this->chassis = $newChasis;
  }
  
  public function getCarChassis() {
    return $this->chassis;
  }

  public function setCarDoors($newDoors) {
    $this->doors = $newDoors;
  }

  public function getCarDoors() {
    return $this->doors;
  }

  public function setCarEngine($newEngine) {
    $this->engine = $newEngine;
  }

  public function getCarEngine() {
    return $this->engine;
  }
}

interface CarBuilder {

  public function buildCarChassis();
  public function buildCarEngine();
  public function buildCarDoors();

  public function getCar();
}

class SedanCarBuilder implements CarBuilder {

  private $sedanCar;

  public function __construct() {
    $this->sedanCar = new Car();
  }

  public function buildCarChassis() {
    $this->sedanCar->setCarChassis('Sedan shaped - trunked Chassis');
  }

  public function buildCarEngine() {
    $this->sedanCar->setCarEngine('Petron Engine');
  }
  public function buildCarDoors() {
    $this->sedanCar->setCarDoors('5 doors including Trunk');
  }
  
  public function getCar() {
    return $this->sedanCar;
  }
}


class CabrioCarBuilder implements CarBuilder {

  private $cabrioCar;

  public function __construct() {
    $this->cabrioCar = new Car();
  }

  public function buildCarChassis() {
    $this->cabrioCar->setCarChassis('Cabrio roofles shape');
  }

  public function buildCarEngine() {
    $this->cabrioCar->setCarEngine('Petron Engine');
  }
  public function buildCarDoors() {
    $this->cabrioCar->setCarDoors('Three doors included');
  }

  public function getCar() {
    return $this->cabrioCar;
  }
}

class CarEngineer {
  private $carBuilder;

  public function __construct(CarBuilder $newCarBuilder) {
    $this->carBuilder = $newCarBuilder;
  }

  public function makeCar() {
    $this->carBuilder->buildCarChassis();
    $this->carBuilder->buildCarEngine();
    $this->carBuilder->buildCarDoors();
  }

  public function getCar() {
    return $this->carBuilder->getCar();
  }
}


class BuilderTest extends \PHPunit_Framework_Testcase {


  
  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }
  
  public function testCabrioBuild() {
    $cabrioBlueprint = new CabrioCarBuilder();

    $cabrioBuild = new CarEngineer($cabrioBlueprint);
    $cabrioBuild->makeCar();

    $miata = $cabrioBuild->getCar();

    print 'Mazda Miata:' . "\n";
    print $miata->getCarChassis() . '' . "\n";
    print $miata->getCarEngine() . '' . "\n";
    print $miata->getCarDoors() . '' . "\n";
  }

  public function testSedanBuild() {
    $sedanBlueprint = new SedanCarBuilder();
  
    $sedanBuild = new CarEngineer($sedanBlueprint);
    $sedanBuild->makeCar();
  
    $mondeo = $sedanBuild->getCar();
  
    print 'Ford Mondeo:' . "\n";
    print $mondeo->getCarChassis() . '' . "\n";
    print $mondeo->getCarEngine() . '' . "\n";
    print $mondeo->getCarDoors() . '' . "\n";
  }
  
}












