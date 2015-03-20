<?php

class CircleGenerator {
  // properties are not extended
  protected $diameter;
  protected $color;
  protected $border;

  public function __construct() {
    // Don't put here anything since we don't want to instantiate the object
    // each time.
  }

  public function setCircle($newCicleParameters) {
    $this->diameter = $newCicleParameters[0];
    $this->color = $newCicleParameters[1];
    $this->border = ($newCicleParameters[2]) ? 'With' : 'without';
  }

  public function getCompas() {
    return $this->diameter * 3.1415;
  }

  public function drawCircle() {
    return 'Drawing a circle with ' . $this->diameter .
            ' and ' . $this->color . ' color ' . $this->border . ' border.' . PHP_EOL;
  }
  // @TODO: here goes another functions that are based on the same properties.
}

class ExpensiveCircleGenerator {
  // properties are not extended
  protected $diameter;
  protected $color;
  protected $border;

  public function __construct($newCicleParameters) {
    $this->diameter = $newCicleParameters[0];
    $this->color = $newCicleParameters[1];
    $this->border = ($newCicleParameters[2]) ? 'With' : 'without';
  }

  public function getCompas() {
    return $this->diameter * 3.1415;
  }


  public function drawCircle() {
    return 'Drawing a circle with ' . $this->diameter .
    ' and ' . $this->color . ' color ' . $this->border . ' border.' . PHP_EOL;
  }
  // @TODO: here goes another functions that are based on the same properties.
}


class FlyweightTest extends \PHPunit_Framework_Testcase {

  static protected $circleOptions;
  static protected $iterations;
  static protected $endPerformant;
  static protected $endExpensive;

  public static function setUpBeforeClass() {

    self::$iterations = 99999;
    self::$circleOptions = array(
      array('1', '#fff', true),
      array('5', '#ccc', false),
      array('3', '#000', false),
      array('6', 'red', true),
      array('7', 'blue', false)
    );
  }

  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }

  public function testCircleGenerator() {
    $startTime = -microtime(true);
    $startMemory = -memory_get_usage();
    for($i=0; $i<self::$iterations; $i++) {
      $circle = new CircleGenerator(self::$circleOptions[rand(0, 4)]);
      print $i . '. ' . $circle->drawCircle();
    }
    $endTime = microtime(true);
    $endMemory = memory_get_usage();
    self::$endPerformant = 'Performant Circle drawing was: ' . ceil(($startTime + $endTime)  * 1000) . 'ms and' .
      ' memory: ' . ($startMemory + $endMemory) . PHP_EOL;
  }

  public function testExpensiveCircleGenerator() {
    $start = -microtime(true);
    $startMemory = -memory_get_usage();
    for($i=0; $i<self::$iterations; $i++) {
      $circle = new CircleGenerator(self::$circleOptions[rand(0, 4)]);
      print $i . '. ' . $circle->drawCircle();
    }
    $end = microtime(true);
    $endMemory = memory_get_usage();
    self::$endExpensive = 'Expensive Circle drawing was: ' . ceil(($start + $end)  * 1000) . 'ms and' .
      ' memory: ' . ($startMemory + $endMemory) . PHP_EOL;
  }

  protected function tearDown() {
    print self::$endPerformant;
    print self::$endExpensive;
  }
}