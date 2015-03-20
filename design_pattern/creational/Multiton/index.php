<?php

abstract class TransportMultiton {
  private static $instances = array();
  
  public static function getInstance() {
    $instanceKey = get_called_class();
    $constructorArguments = func_get_args();

    if(!array_key_exists($instanceKey, self::$instances)) {
      $reflectionClass = new ReflectionClass(get_called_class());
      self::$instances[$instanceKey] = $reflectionClass->newInstanceArgs($constructorArguments);
    }
    return self::$instances[$instanceKey];
  }
}


class Car extends TransportMultiton {
  
  public function __construct() {
    print 'New class instance of ' . get_called_class() . ' added.'. "\n";
  }
  
  public function exampleCall($subjectiveWay = null) {
    print 'Traveling with car is ' . $subjectiveWay . "\n";
  }
}

class Airplane extends TransportMultiton {
  
  public function __construct() {
     print 'New class instance of ' . get_called_class() . ' added.'. "\n";
  }
  
  public function exampleCall($subjectiveWay = null) {
    print 'Flying with an Airplane is ' . $subjectiveWay . "\n";
  }
}


class MultitonTest extends \PHPunit_Framework_Testcase {
  
  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }

  public function testCar() {
    $carInstance = Car::getInstance();
    $carInstance->exampleCall('Comfortable way');
  }
  
  public function testAirplane() {
    $airplaneInstance = Airplane::getInstance();
    $airplaneInstance->exampleCall('Fast way');
  }
  
  public function testAirplaneAgain() {
    $airplaneInstanceAnother = Airplane::getInstance();
    $airplaneInstanceAnother->exampleCall('Economic way');
  }
}
