<?php

// bounds for the subjects (observers) and the publishers
interface StockManger {
    public function registerObserver(Observer $observer);
    public function unregisterObserver(Observer $observer);
    public function updateObserver(Observer $observer);
    public function updateObservers();
}

interface Observer {
    public function update($ibmPrice, $aaplPrice, $googPrice);
}


class StockBroker implements StockManger {
    // $observers collects Observer objects

    // @type: Observer
    private $observers;

    private $ibmPrice;
    private $aaplPrice;
    private $googPrice;

    private $observerIdTracker = 0;
    private $actualObserverId;

    public function __construct() {
        $this->observers = array();
    }

    public function registerObserver(Observer $newObserver) {
        $this->actualObserverId = intval(++$this->observerIdTracker);
        $newObserver->setObserverId($this->actualObserverId);
        $this->observers[$this->actualObserverId] = $newObserver;
    }

    public function unregisterObserver(Observer $toDeleteObserver) {
        // trying to be defensive
        if (array_key_exists($toDeleteObserver->observerId, $this->observers)) {
            print 'Removed observer: ' . $this->observers[$toDeleteObserver->observerId]->observerId . PHP_EOL;
            unset($this->observers[$toDeleteObserver->observerId]);
        }
    }

    public function updateObservers() {
        foreach ($this->observers as $observer) {
            // since  $observer values are Observer instances - objects
            $observer->update($this->ibmPrice, $this->aaplPrice, $this->googPrice);
        }
    }

    public function updateObserver(Observer $observer) {
        $observer->update($this->ibmPrice, $this->aaplPrice, $this->googPrice);
    }

    public function setIbmPrice($newIbmPrice) {
        $this->ibmPrice = $newIbmPrice;
    }

    public function setAaplPrice($newAaplPrice) {
        $this->aaplPrice = $newAaplPrice;
    }

    public function setGoogPrice($newGoogPrice) {
        $this->googPrice = $newGoogPrice;
    }

    public function getObservers() {
        return $this->observers;
    }
}


class StockObserver implements Observer {
    private $ibmPrice;
    private $aaplPrice;
    private $googPrice;

    public $observerId;
    private $stockPublisher;

    // dependency injection of the StockMangaer - StockBroker
    public function __construct(StockManger $stockBroker) {
        $this->stockPublisher = $stockBroker;
    }

    public function update($newIbmPrice, $newAaplPrice, $newGoogPrice) {
        // actualize the new values within the observer
        $this->ibmPrice = $newIbmPrice;
        $this->aaplPrice = $newAaplPrice;
        $this->googPrice = $newGoogPrice;
    }

    public function printPrices() {
        print 'Observer Id: ' . $this->observerId . PHP_EOL;
        print $this->ibmPrice . PHP_EOL;
        print $this->aaplPrice . PHP_EOL;
        print $this->googPrice . PHP_EOL;
    }

    public function setObserverId($observerId) {
        $this->observerId = $observerId;
    }
}


class ObserverTest extends \PHPUnit_Framework_TestCase {
    public function testSimpleSpecification() {

        // Setting base values
        $stockPublisher = new StockBroker();

        $observer1 = new StockObserver($stockPublisher);
        $observer2 = new StockObserver($stockPublisher);

        $stockPublisher->registerObserver($observer1);
        $stockPublisher->registerObserver($observer2);

        $stockPublisher->setIbmPrice(197.00);
        $stockPublisher->setaaplPrice(194.00);
        $stockPublisher->setGoogPrice(201.00);
        $stockPublisher->updateObservers();

        $observer1->printPrices();
        $observer2->printPrices();

        $stockPublisher->setIbmPrice(198.06);
        $stockPublisher->setaaplPrice(195.03);
        $stockPublisher->setGoogPrice(217.00);
        $stockPublisher->updateObservers();

        $observer1->printPrices();
        $observer2->printPrices();

        $stockPublisher->setIbmPrice(190.06);
        $stockPublisher->setaaplPrice(156.03);
        $stockPublisher->setGoogPrice(198.00);
        $stockPublisher->updateObservers();

        $observer1->printPrices();
        $observer2->printPrices();
    }

    public function testUnsubscribe() {
        $stockPublisher = new StockBroker();

        $observer1 = new StockObserver($stockPublisher);
        $observer2 = new StockObserver($stockPublisher);
        $observer3 = new StockObserver($stockPublisher);

        $stockPublisher->registerObserver($observer1);
        $stockPublisher->registerObserver($observer2);
        $stockPublisher->registerObserver($observer3);

        $stockPublisher->unregisterObserver($observer2);

        print 'Resulting Observers: ' . PHP_EOL;
        foreach($stockPublisher->getObservers() as $observer) {
            print $observer->observerId . PHP_EOL;
        }
    }

    public function testDelimiter() {
        echo PHP_EOL . " ------------------" . PHP_EOL;
    }
}
