<?php


// get dispose

// getInstance getResource 

// create validate expire    lock unlock



abstract class AbstractPool {
  abstract protected function lockResource($resourceName);
  abstract protected function unlockResource($resourceName);
  abstract public function getInstance($resourceName);
}


class ObjectPool extends AbstractPool {
  
  private $resourceStatus;
  private $resourceAvailable;

  public function __construct() {
    $this->resourceStatus = array();
    $this->resourceAvailable = array();
    print ' construct ';
  }

  
  public function getInstance($resourceName) {
    
    if(!array_key_exists($resourceName, $this->resourceAvailable)) {
      // Instantiate new object
      $this->initializeResource($resourceName);
      $this->lockResource($resourceName);
      return $this->resourceAvailable[$resourceName];
    } elseif (!$this->resourceStatus[$resourceName]) {
      return $this->resourceAvailable[$resourceName];
    } else {
      // Default behavior
      print 'Resource ' . $resourceName . ' is already in use'; 
      return false;
    }
  }

  protected function lockResource($resourceName) {
    return $this->resourceStatus[$resourceName] = mktime();
  }

  public function unlockResource($resourceName) {
     $this->resourceStatus[$resourceName] = false;
  }

  private function initializeResource($resourceName) {
    if (class_exists($resourceName)) {
     $this->resourceAvailable[$resourceName] =  new $resourceName();
    }
  }
}


interface  HardWorkHandler {
  public function handleWork($type);
}


class HeavyDutyDriller implements HardWorkHandler {
  
  public function __construct() {
    print 'HeavyDutyDriller has been initiated ' . "\n";
  }

  public function handleWork($type) {
    print 'Executing hard work with Heavy Duty Driller. Notice: ' . $type . "\n";
  }
}

class HeavyDutyJigsaw implements HardWorkHandler {

  public function __construct() {
    print 'HeavyDutyJigsaw has been initiated ' . "\n";
  }

  public function handleWork($type) {
    print 'Executing hard work with Heavy Duty Jigsaw. Notice: ' . $type . "\n";
  }
}

class ObjectPoolTest extends \PHPunit_Framework_Testcase {
  
  protected static $objectPool;
  
  public static function setUpBeforeClass() {
    self::$objectPool = new ObjectPool();

  }
  
  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }
  
  public function testJigsawOne() {
    $jigsawOne = self::$objectPool->getInstance('HeavyDutyJigsaw');
    $jigsawOne->handleWork('cutting');
    // unlocking the resource
    self::$objectPool->unlockResource('HeavyDutyJigsaw');
  }

  public function testDriller() {
    $driller = self::$objectPool->getInstance('HeavyDutyDriller');
    $driller->handleWork('drilling holes');
  }

  public function testJigsawTwo() {
    // Instantiatin resource second time
    $jigsawTwo = self::$objectPool->getInstance('HeavyDutyJigsaw');
    // No initialization here
    $jigsawTwo->handleWork('cutting again (no new instance)');
  }
  
}