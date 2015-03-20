<?php

class Memento {
    // @type: string
    private $population;
    // @type: int
    private $dateIndex;

    public function __construct($newPopulationSum, $newDateIndex) {
        $this->population = $newPopulationSum;
        $this->dateIndex = $newDateIndex;
    }

    public function getPopulation() {
        return $this->population;
    }

    public function getDateIndex() {
        return $this->dateIndex;
    }
}

class Originator {
    // @type: strint
    private $currentMemento;

    public function setCurrentMemento(Memento $newMemento) {
        $this->currentMemento = $newMemento;
    }

    public function makeMemento($population) {
        print 'Storing Population Memento: ' . $population . PHP_EOL;
        return new Memento($population, $population . '_id');
    }

    public function retrievePopulation() {
        return $this->currentMemento->getPopulation();
    }

}

class Caretaker {

    private $mementoData;
    public function addMemento(Memento $newMemento)  {
        $this->mementoData[$newMemento->getDateIndex()] = $newMemento;
    }

    public function getMemento($mementoIndex) {
        if(array_key_exists($mementoIndex, $this->mementoData)) {
            return $this->mementoData[$mementoIndex];
        } else {

            throw new Exception('Memento with the ID: ' . $mementoIndex . ' could not be found.');
        }

    }
}


class MementoTest extends \PHPUnit_Framework_TestCase {

    public function testMemento() {
        $originator = new Originator();
        $caretaker = new Caretaker();

        $memento1 = $originator->makeMemento(123);
        $caretaker->addMemento($memento1);

        $memento2 = $originator->makeMemento(124);
        $caretaker->addMemento($memento2);

        $memento3 = $originator->makeMemento(127);
        $caretaker->addMemento($memento3);

        $retrieve123 = $caretaker->getMemento(124 . '_id');
        $originator->setCurrentMemento($retrieve123);

        print 'Population at 124_id is: ' . $originator->retrievePopulation() . PHP_EOL;

    }

    protected function assertPostConditions() {
        print "---------------------------------------------------------------- \n";
    }
}
