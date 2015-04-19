<?php


abstract class NailPrototype {
  
  protected $nailMaterial = 'Iron';
  protected $nailLength = 1;
  
  abstract function __clone();
  
  public function setMaterial($newMaterial) {
    $this->nailMaterial = $newMaterial;
  }
  
  public function  setLength($newLength) {
    $this->nailLength = $newLength;
  }
 
  public function getMaterial() {
    return $this->nailMaterial;
  }
  
  public function getLength() {
    return $this->nailLength;
  }
}

class ShortNails extends NailPrototype {
  protected $nailLength;
  
  public function __construct() {
    $this->nailLength = parent::getLength();
  }
  
  public function __clone() { }
  
}

class LongNails extends NailPrototype {
  protected $nailLength = 'longer length';

  public function __clone() {
  }

}

class ObjectPoolTest extends \PHPunit_Framework_Testcase {

  static protected $shortNails;
  static protected $longNails;

  public static function setUpBeforeClass() {
    self::$shortNails = new ShortNails();
    self::$longNails = new LongNails();
  }

  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }
  
  public function testMakeManyIncrementalShortNails() {
    $myShortNails = clone self::$shortNails;
    $myShortNails->setMaterial('Inox');

    for($i=0; $i < 10; $i++) {
      if($i === 5)  {
        $myShortNails->setLength(1.5); 
      }
      print 'Nail order nr. #: ' . $i . "\n";
      print ($myShortNails->getLength() + $i) . ' cm Length'. "\n";
      print 'Material: ' . $myShortNails->getMaterial() . "\n";
    }
    print 'The original prototyped Nails are from: ' . self::$shortNails->getMaterial() . "\n";
  }
}