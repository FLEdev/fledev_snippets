<?php

interface PizzaInterface {
  public function setMeet($newMeet);
  public function setCheese($newCheese);
  public function setExtra($newExtra);
}

class PizzaMaker implements PizzaInterface {
  public $meet;
  public $cheese;
  public $extra;
  public $resultingPizzaName;
  
  public function __construct($newIngredients) {
    $this->meet = $newIngredients->getMeet();
    $this->cheese = $newIngredients->getCheese();
    $this->extra = $newIngredients->getExtra();
    $this->resultingPizzaName = $newIngredients->getResultingPizzaName();
  }
  
  public function setMeet($newMeet) {
    $this->meet = $newMeet;
  }

  public function setCheese($newCheese) {
    $this->meet = $newMeet;
  }

  public function setExtra($newExtra) {
    $this->extra = $newExtra;
  }

  public function printOut() {
    print 'Pizza name: '  . $this->resultingPizzaName . "\n";
    print 'Cheese: ' . (($this->cheese) ? ' yes ' : 'no') . "\n";
    print 'Meet: ' . (($this->meet) ? ' yes ' : 'no') . "\n";
    print 'Extra: ' . (($this->extra) ? $this->extra : 'no') . "\n";
  }
}

interface PizzaIngredientsInterface {
  public function getResultingPizzaName();
  public function getMeet();
  public function getCheese();
  public function getExtra();
}

class MargheritaPizzaIngredients implements PizzaIngredientsInterface{
  private $cheese;
  private $meet;
  private $extra;
  private $resultingPizzaName;

  public function __construct() {
    $this->resultingPizzaName = 'Margherita';
    $this->cheese = true;
    $this->meet = true;
    $this->extra = 'Tomato souce';
  }
  
  public function getResultingPizzaName() {
    return $this->resultingPizzaName;
  }
  
  public function getMeet() {
    return $this->meet;
  }

  public function getCheese() {
    return $this->cheese;
  }

  public function getExtra() {
    return $this->extra;
  }
}

class VegetarianPizzaIngredients implements PizzaIngredientsInterface{
  private $cheese;
  private $meet;
  private $extra;
  private $resultingPizzaName;
  
  public function __construct() {
    $this->resultingPizzaName = 'Vegetarian';
    $this->cheese = true;
    $this->meet = false;
    $this->extra = 'Rucola';
  }
  
  public function getResultingPizzaName() {
    return $this->resultingPizzaName;
  }
  
  public function getMeet() {
    return $this->meet;
  }

  public function getCheese() {
    return $this->cheese;
  }

  public function getExtra() {
    return $this->extra;
  }
}

interface PizzaFactoryInterface{
  public function create($type);
}

class PizzaFactory implements PizzaFactoryInterface{
  public function create($type = null) {
    switch(strtolower($type)) {
      case 'vegetarian':
        return new PizzaMaker(new VegetarianPizzaIngredients());
        break;
      case 'margherita': default:
        return new PizzaMaker(new MargheritaPizzaIngredients());
      break;
    }
  }
}

// use this interpretation where mocking doesn't make sense.
class PizzaStaticFactory {
  /*
   * @param strint $type
   * @return PizzaMaker
   */
  public static function create($type = NULL) {
    switch(strtolower($type)) {
      case 'vegetarian':
        return new PizzaMaker(new VegetarianPizzaIngredients());
        break;
      case 'margherita': default:
        return new PizzaMaker(new MargheritaPizzaIngredients());
        break;
    }
  }
}

class FactoryTest extends \PHPunit_Framework_Testcase {
  private $basePizza;
  
  protected function setUp() {
    $this->basePizza = new PizzaFactory();
  }
  
  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }
  
  public function testVegetarian() {
    $margherita = $this->basePizza->create('vegetarian');
    $margherita->printOut();
  }
  
  public function testMargherita() {
    $margherita = $this->basePizza->create('margherita');
    $margherita->printOut();
  }
  
  public function testDefault() {
    $margherita = $this->basePizza->create();
    $margherita->printOut();
  }
  
  public function testStaticMargherita() {
    $margherita = PizzaStaticFactory::create('margherita');
    $margherita->printOut();
  }
  
  public function testStaticVegetarian() {
    $margherita = PizzaStaticFactory::create('vegetarian');
    $margherita->printOut();
  }
}

