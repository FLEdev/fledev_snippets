<?php

interface Shape {
  public function draw();
}

class Circle implements Shape {
  public function draw()  {
    print 'drawing a Circle shape.' . " \n";
  }

}
class Rectangle implements Shape {
  public function draw()  {
    print 'drawing a Rectangle shape.' . " \n";
  }
}


interface Color {
  public function fill();
}

class RedColor implements Color {
  public function fill() {
    print 'Filling shape with RED color' ."\n";
  }
}

class GreenColor implements Color {
  public function fill() {
    print 'Filling shape with GREEN color' ."\n";
  }
}


abstract class AbstractShapeFactory{
  abstract function getColor($color);
  abstract function getShape($shape);
}

class ShapeFactory extends AbstractShapeFactory{
  public function getShape($shape) {
    switch(strtolower($shape)) {
      case 'rectangle':
        return new Rectangle();
      break;
      case 'circle':
        return new Circle();
      break;
    }
  }
  
  public function getColor($color) {
    return null;
  }
}

class ColorFactory extends AbstractShapeFactory{
  public function getShape($shape) {
    return null;
  }

  public function getColor($color) {
    switch(strtolower($color)) {
        case 'red':
          return new RedColor();
        break;
        case 'green':
          return new GreenColor();
        break;
      }
  }
}

class DesignFactoryProducer {
  public static function getFactory($type) {
    switch(strtolower($type)) {
      case 'color':
        return new ColorFactory();
      break;
      case 'shape':
        return new ShapeFactory();
      break;
    }
  }
}


class AbstractFactoryTest extends \PHPunit_Framework_Testcase {
  
  protected $shapeFactory;
  protected $colorFactory;
  
  public function setUp() {
    $this->testFactoryGeneration();
  }
  
  public function testFactoryGeneration() {
    $this->shapeFactory = DesignFactoryProducer::getFactory('shape');
    $this->colorFactory = DesignFactoryProducer::getFactory('color');
  }
  
  public function testGreenCircle() {
    $circle = $this->shapeFactory->getShape('circle');
    $circle->draw();
    $color = $this->colorFactory->getColor('green');
    $color->fill();
  }
  
  public function testRedRectangle() {
    $circle = $this->shapeFactory->getShape('rectangle');
    $circle->draw();
    $color = $this->colorFactory->getColor('red');
    $color->fill();
  }

  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }
}



