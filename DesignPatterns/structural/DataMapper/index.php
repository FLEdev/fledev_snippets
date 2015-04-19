<?php

interface InformationBlueprint {
  public function getId();
  public function getBookName();
  public function getAuthor();
}

class BookCatalogueItem implements InformationBlueprint {
  private $id;
  private $bookName;
  private $author;

  public function __construct($newId, $newBookName, $newAuthor) {
    $this->id = $newId;
    $this->bookName = $newBookName;
    $this->author = $newAuthor;
  }

  public function getBookName() {
    return $this->bookName;
  }

  public function getAuthor() {
    return $this->author;
  }

  public function getId() {
    return $this->id;
  }
}

interface MapperBlueprint {
  public function addItem(InformationBlueprint $newItem);
  public function findById($idReference);
  // Optional range as min max parameter
  public function getRange($min, $max);
}

class CatalogueMapper implements MapperBlueprint{

  public $catalogue;

  function __construct() {
    $this->catalogue = array();
  }

  public function addItem(InformationBlueprint $newItem) {
    if(!in_array($newItem, $this->catalogue)) {
      $this->catalogue[$newItem->getId()] = $newItem;
    }
  }

  public function findById($idReference) {
    if(isset($this->catalogue[$idReference])) {
      return $this->catalogue[$idReference];
    } else {
      return false;
    }
  }

  public function displayBookInfo(InformationBlueprint $book) {
    print 'Id: ' . $book->getId() . PHP_EOL;
    print 'Name: ' . $book->getBookName() . PHP_EOL;
    print 'Author: ' . $book->getAuthor() . PHP_EOL;
  }

  public function getRange($min = 0, $max = 0) {
    return array_slice($this->catalogue, $min, $max);
  }
}

class DataMapperTest extends \PHPunit_Framework_Testcase {

  static protected $catalogue;

  public static function setUpBeforeClass() {
    self::$catalogue = new CatalogueMapper();
  }

  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }

  public function testAddItem() {
    self::$catalogue->addItem(new BookCatalogueItem('HP003', 'Prisoner of Azkaban', 'Joanne K. Rowling'));
    self::$catalogue->addItem(new BookCatalogueItem('HP004', 'Harry Potter and the Goblet of Fire', 'Joanne K. Rowling'));
    self::$catalogue->addItem(new BookCatalogueItem('HP005', 'Harry Potter and the Order of the Phoenix', 'Joanne K. Rowling'));
  }

  public function testFindById() {
    self::$catalogue->addItem(new BookCatalogueItem('HP003', 'Prisoner of Azkaban', 'Joanne K. Rowling'));
    self::$catalogue->addItem(new BookCatalogueItem('HP004', 'Harry Potter and the Goblet of Fire', 'Joanne K. Rowling'));
    $hp004 = self::$catalogue->findById('HP004');
    $this->assertTrue(is_object($hp004));
    self::$catalogue->displayBookInfo($hp004);
  }

  public function testGetRange() {
    self::$catalogue->addItem(new BookCatalogueItem('HP003', 'Prisoner of Azkaban', 'Joanne K. Rowling'));
    self::$catalogue->addItem(new BookCatalogueItem('HP004', 'Harry Potter and the Goblet of Fire', 'Joanne K. Rowling'));
    self::$catalogue->addItem(new BookCatalogueItem('HP004', 'Harry Potter and the Goblet of Fire', 'Joanne K. Rowling'));
    self::$catalogue->addItem(new BookCatalogueItem('HP005', 'Harry Potter and the Order of the Phoenix', 'Joanne K. Rowling'));
    self::$catalogue->addItem(new BookCatalogueItem('HP005', 'Harry Potter and the Order of the Phoenix', 'Joanne K. Rowling'));
    self::$catalogue->addItem(new BookCatalogueItem('HP003', 'Prisoner of Azkaban', 'Joanne K. Rowling'));
    self::$catalogue->addItem(new BookCatalogueItem('HP006', 'Harry Potter and the Half-Blood Prince', 'Joanne K. Rowling'));
    $rangeArray = self::$catalogue->getRange(1,3);
    $countRangeArray = count($rangeArray);
    $this->assertTrue($countRangeArray == 3);

    foreach($rangeArray as $bookItem) {
      self::$catalogue->displayBookInfo($bookItem);
    }
  }
}