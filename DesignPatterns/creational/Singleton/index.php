<?php

class SingletonInstance {
  private static $selfInstance;
  
  public static function getSelfInstance() {
    if(null === static::$selfInstance) {
      // correct way to call self
      self::$selfInstance = new static();
    }
    return self::$selfInstance; 
  }
 
  // prevent creating via magic functions
  private function __construct(){
    // here could be the external classes be initialized and assigned to $selfInstance
  }
  private function __clone(){ }
  private function __wakeUp(){ }
}


class SingletonTest extends \PHPunit_Framework_Testcase {

  public static function setUpBeforeClass() {  }

  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }
  
  public function testUnique() {
    $callOne = SingletonInstance::getSelfInstance();
    $this->assertInstanceOf('SingletonInstance', $callOne);
    $callTwo = SingletonInstance::getSelfInstance();
    $this->assertSame($callOne, $callTwo);
    print 'Call One and call Two are the same.' . "\n";
  }
  
  public function testNoConstructor() {
    $SiInstance = SingletonInstance::getSelfInstance();
    
    $classReflection = new \ReflectionClass($SiInstance);
    $construcorMethod = $classReflection->getMethod('__construct');
    $this->assertTrue($construcorMethod->isPrivate());
  }
  
}