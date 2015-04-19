<?php

class StockOffer {

    private $stockQuantity;
    private $stockSymbol;
    private $colleagueCode;

    public function __construct($newStockQuantity = 0, $newStockSymbol = '', $newCollCode = 0) {
        $this->stockQuantity = $newStockQuantity;
        $this->colleagueCode = $newCollCode;
        $this->stockSymbol = $newStockSymbol;
    }

    public function getStockQuantity() {
        return $this->stockQuantity;
    }

    public function getStockSymbol() {
        return $this->stockSymbol;
    }

    public function getColleagueCode() {
        return $this->colleagueCode;
    }
}


abstract class Colleague {
    private $mediator;
    private $colleagueCode;


    protected function addColleague($newMediator) {
        $this->mediator = $newMediator;
        $this->mediator->addColleague($this);
    }

    public function sellOffer($stock, $shares) {
        $this->mediator->sellOffer($stock, $shares, $this->colleagueCode);
    }

    public function buyOffer($stock, $shares) {
        $this->mediator->buyOffer($stock, $shares, $this->colleagueCode);
    }

    public function addCollCode(int $newCollCode) {
        $this->colleagueCode = $newCollCode;
    }
}


class GormanSlacks extends Colleague {
    public function __construct($newMediator) {
        parent::addColleague($newMediator);
        print 'Added new Colleague: Gorman Slacks. ' . PHP_EOL;
    }
}


class JTPoorman extends Colleague {
    public function __construct($newMediator) {
        parent::addColleague($newMediator);
        print 'Added new Colleague: JT Poorman. ' . PHP_EOL;
    }
}


interface Mediator {
    public function buyOffer($stock, $shares, $collCode);

    public function sellOffer($stock, $shares, $collCode);

    public function addColleague(Colleague $newColleague);
}


class StockMediator implements Mediator {

    private $colleagues;
    private $stockOfferBuy;
    private $stockOfferSell;

    private $colleagueCodes;

    public function __construct() {
        $this->colleagues = $this->stockOfferBuy = $this->stockOfferSell = array();
        $this->colleagueCodes = 0;
    }


    public function buyOffer($stock, $shares, $collCode) {
        $stockBought = false;
        // Go through each sell offers and look for appropriate sell offers
        foreach ($this->stockOfferSell as $offerKey => $offer) {
            if ($offer->getStockSymbol() == $stock && $offer->getStockQuantity() >= $shares) {
                unset($this->stockOfferSell[$offerKey]);
                print 'Bought: ' . $stock . ' shares:' . $shares  . PHP_EOL;
                break(1);
            }
        }
        if(!$stockBought) {
            $this->stockOfferBuy[] = new StockOffer($shares, $stock, $collCode);
        }
    }

    public function sellOffer($stock, $shares, $collCode) {
        $stockBought = false;
        // Go through each sell offers and look for appropriate sell offers
        foreach ($this->stockOfferBuy as $offerKey => $offer) {
            if ($offer->getStockSymbol() == $stock && $offer->getStockQuantity() >= $shares  ) {
                unset($this->stockOfferBuy[$offerKey]);
                print 'Sold: ' . $stock . ' shares:' . $shares . PHP_EOL;
                break(1);
            }
        }
        if(!$stockBought) {
            $this->stockOfferSell[] = new StockOffer($shares, $stock, $collCode);
        }
    }

    public function addColleague(Colleague $newColleague) {
        if (in_array($newColleague, $this->colleagues)) {
            $this->colleagueCodes++;
            $newColleague->setCollCode($this->colleagueCodes);
            $this->colleagues[] = $newColleague;
        }
    }
}

class MediatorTest extends \PHPUnit_Framework_TestCase {
    public function testBrokerageMediation() {
        $charlie = new StockMediator();

        $gsBroker = new GormanSlacks($charlie);
        $jtpBroker = new JTPoorman($charlie);

        $gsBroker->sellOffer('MSFT', 100);
        $jtpBroker->buyOffer('GOOG', 100);
        $gsBroker->sellOffer('GOOG', 50);

        $jtpBroker->buyOffer('MSFT', 100);
        $gsBroker->sellOffer('NRG', 10);

    }

    protected function assertPostConditions() {
        print "---------------------------------------------------------------- \n";
    }
}
