<?php

interface SpecificationInterface {
  
  public function isSatisfiedBy(Item $item);
  public function plus(SpecificationInterface $specification);
  public function either(SpecificationInterface $specification);
  public function not(SpecificationInterface $specification);
}


abstract class AbstractSpecification implements SpecificationInterface{
  abstract public function isSatisfiedBy(Item $item);
  
  public function plus(SpecificationInterface $specification) {
    return new PlusAnd($this, $specification);
  }
  
  public function either(SpecificationInterface $specification) {
    return new EitherOr($this, $specification);
  }
  
  public function not(SpecificationInterface $specification) {
    return new Not($this);
  }
}


// ------------------------------------------------------------------

class PlusAnd extends AbstractSpecification {
  protected $left;
  protected $right;
  
  public function __construct(SpecificationInterface $newLeft, SpecificationInterface $newRight) {
    $this->left = $newLeft;
    $this->right = $newRight;
  }
  
  public function isSatisfiedBy(Item $item) {
    return $this->left->isSatisfiedBy($item) && $this->right->isSatisfiedBy($item);
  } 
}

class EitherOr extends AbstractSpecification {
  protected $left;
  protected $right;

  public function __construct(SpecificationInterface $newLeft, SpecificationInterface $newRight) {
    $this->left = $newLeft;
    $this->right = $newRight;
  }

  public function isSatisfiedBy(Item $item) {
    return $this->left->isSatisfiedBy($item) || $this->right->isSatisfiedBy($item);
  }
}

class Not extends AbstractSpecification {
  
  /*
   * @type: Specificatoin
   */
  protected $specification;

  public function __construct(SpecificationInterface $newSpecification) {
    $this->specification = $newSpecification;
  }

  public function isSatisfiedBy(Item $item) {
    return !$this->specification->isSatisfiedBy($item);
  }

}
// ------------------------------------------------------------------

class PriceSpecification extends AbstractSpecification {
  protected $maxPrice;
  protected $minPrice;
  
  public function setMaxPrice($newMaxPrice) {
    $this->maxPrice = $newMaxPrice;
    echo 'Max price: ' . $this->maxPrice . "\n";
  }
  
  public function setMinPrice($newMinPrice) {
    $this->minPrice = $newMinPrice;
    echo 'Min price: ' . $this->minPrice . "\n";
  }
  
  public function isSatisfiedBy(Item $item) {
    if (!empty($this->maxPrice) && $item->getPrice() > $this->maxPrice) {
      echo 'OK, satisfying ' . "\n";
      return false;
    }
    if (!empty($this->minPrice) && $item->getPrice() < $this->minPrice) {
      echo 'Not satisfying ' . "\n";
      return false;
    }
  
    return true;
  }
}

class Item {
  
  protected $price;
  
  public function __construct($newPrice) {
    $this->price = $newPrice;
  }
  
  public function getPrice() {
    return $this->price;
  }
}

class SpecificationTest extends \PHPUnit_Framework_TestCase
{
  public function testSimpleSpecification()
  {
    $item = new Item(100);
    $spec = new PriceSpecification();
    echo 'Satisfaction: ' . $spec->isSatisfiedBy($item) . "\n";
    $this->assertTrue($spec->isSatisfiedBy($item));

    $spec->setMaxPrice(50);
    echo 'Satisfaction: ' . $spec->isSatisfiedBy($item) . "\n";
    $this->assertFalse($spec->isSatisfiedBy($item));

    $spec->setMaxPrice(150);
    echo 'Satisfaction: ' . $spec->isSatisfiedBy($item) . "\n";
    $this->assertTrue($spec->isSatisfiedBy($item));


    $spec->setMinPrice(101);
    echo 'Satisfaction: ' . $spec->isSatisfiedBy($item) . "\n";
    $this->assertFalse($spec->isSatisfiedBy($item));

    $spec->setMinPrice(100);
    echo 'Satisfaction: ' . $spec->isSatisfiedBy($item) . "\n";
    $this->assertTrue($spec->isSatisfiedBy($item));
  }
  
  public function testDelimiter(){
    echo "\n ------------------ \n";
  }
  
  public function testNotSpecification() {
    $item = new Item(100);
    $spec = new PriceSpecification();
    $not = $spec->not($spec);
  
    $this->assertFalse($not->isSatisfiedBy($item));
  
    $spec->setMaxPrice(50);
    $this->assertTrue($not->isSatisfiedBy($item));
  
    $spec->setMaxPrice(150);
    $this->assertFalse($not->isSatisfiedBy($item));
  
    $spec->setMinPrice(101);
    $this->assertTrue($not->isSatisfiedBy($item));
  
    $spec->setMinPrice(100);
    $this->assertFalse($not->isSatisfiedBy($item));
  }
  
}


