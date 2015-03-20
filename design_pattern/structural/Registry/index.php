<?php

interface RegistryBase {
  public function getData($key);
  public function setData($newData, $key);
}

class Library implements RegistryBase {
  public $database;


  public function setData($newData, $key = '') {
    if(array_search($this->database, $newData) === false) {
      $this->database[$key] = $newData;
    }
  }

  public function getData($key) {
    return (isset($this->database[$key])) ? implode(' ', $this->database[$key]) : false;

  }
}


class RegistryTest extends \PHPunit_Framework_Testcase {

  public static function setUpBeforeClass() {
  }

  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }

  public function testAtmMachine() {
    $library = new Library();
    $library->setData(array('Coelho', 'Magician'), 'coelho01');
    $library->setData(array('Coelho', 'Eleven Minutes'), 'coelho02');
    print $library->getData('coelho02') . PHP_EOL;
    print $library->getData('coelho01') . PHP_EOL;
  }
}