<?php


abstract class MealServe {

  public final function serveMeal() {
    $this->drink();
    $this->appetizer();
    $this->mainMeal();
    $this->secondMeal();
    $this->dessert();
  }

  protected function appetizer(){ }
  protected function soup(){ }

  // This is to implement since everyone is thirsty
  abstract protected function drink();
  // final function so extending classes will not change the main meals
  protected function mainMeal() {
    print 'Serving daily meal';
  }

  protected function secondMeal() { }
  protected function dessert() { }
}

class ChineeseMealServe extends MealServe {
  protected function soup() {
    print 'Enjoy the spicy soup.' . "\n";
  }

  protected function drink() {
    print 'Thai Beer' . "\n";
  }
  
  protected function mainMeal() {
    print 'Serving orange chicken.' . "\n";
  }
}


class FrenchMealServe extends MealServe {
  protected function soup() {
    print 'Enjoy the light soup.' . "\n";
  }

  protected function appetizer() {
    print 'Have a taste of Chevre Truffles' . "\n";
  }
  
  protected function drink() {
    print 'Wine? red or white?' . "\n";
  }

  protected function mainMeal() {
    print 'Serving Buckwheat Crêpes.' . "\n";
  }
  
  protected function secondMeal() {
    print 'Serving Blanquette de Veau.' . "\n";
  }
  
  protected function dessert() {
    print 'Servin Clafoutis.' . "\n";
  }
}

class OrdinaryMeal extends MealServe {
  
  protected function drink() {
    print 'Serving plain wather' . "\n";
  }
}


class TestMealServe extends \PHPunit_Framework_Testcase {
  
  public function testChineeseMeal(){
    print 'Chineese meal: ' . "\n";
    $chineeseMeal = new ChineeseMealServe();
    $chineeseMeal->serveMeal();
    echo "\n ------------------ \n";
  }
  
  public function testFrenchMeal() {
    print 'French meal: ' . "\n";
    $frenchMeal = new FrenchMealServe();
    $frenchMeal->serveMeal();
    echo "\n ------------------ \n";
  }
  
  public function testDailyMeal() {
    print 'Ordinary meal: ' . "\n";
    $ordinaryMeal = new OrdinaryMeal();
    $ordinaryMeal->serveMeal();
    echo "\n ------------------ \n";
  }
}












