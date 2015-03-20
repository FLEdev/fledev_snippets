<?php

interface Chain {
    public function setNextChain(Chain $nextChain);

    public function calculate($request);
}

class Numbers {
    private $number1;
    private $number2;

    private $calculationOperation;

    public function __construct($newNumber1, $newNumber2, $newOperation) {
        $this->number1 = $newNumber1;
        $this->number2 = $newNumber2;
        $this->calculationOperation = $newOperation;
    }

    public function getNumber1() {
        return $this->number1;
    }

    public function getNumber2() {
        return $this->number2;
    }

    public function getCalculationOperation() {
        return $this->calculationOperation;
    }
}

class AddNumbers implements Chain {

    private $nextInChain;

    public function setNextChain(Chain $nextChain) {
        $this->nextInChain = $nextChain;
    }

    /*
     *  @param Request $request;
     */
    public function calculate($request) {
        if ($request->getCalculationOperation() === 'add') {

            $printArray = array(PHP_EOL . 'Added ', $request->getNumber1() . ' + ', $request->getNumber2() . ' = ', ($request->getNumber1() + $request->getNumber2() . PHP_EOL));
            print implode('', $printArray);

        } else {
            $this->nextInChain->calculate($request);
        }
    }
}


class SubstractNumbers implements Chain {

    private $nextInChain;

    public function setNextChain(Chain $nextChain) {
        $this->nextInChain = $nextChain;
    }

    /*
     *  @param Request $request;
     */
    public function calculate($request) {
        if ($request->getCalculationOperation() === 'substract') {

            $printArray = array(PHP_EOL . 'Substracted ', $request->getNumber1() . ' - ', $request->getNumber2() . ' = ', ($request->getNumber1() - $request->getNumber2() . PHP_EOL));
            print implode('', $printArray);

        } else {
            $this->nextInChain->calculate($request);
        }
    }
}


class MultiplyNumbers implements Chain {

    private $nextInChain;

    public function setNextChain(Chain $nextChain) {
        $this->nextInChain = $nextChain;
    }

    /*
     *  @param Request $request;
     */
    public function calculate($request) {
        if ($request->getCalculationOperation() === 'multiply') {

            $printArray = array(PHP_EOL . 'Multipliy ', $request->getNumber1() . ' * ', $request->getNumber2() . ' = ', ($request->getNumber1() * $request->getNumber2() . PHP_EOL));
            print implode('', $printArray);

        } else {
            $this->nextInChain->calculate($request);
        }
    }
}


class DivideNumbers implements Chain {

    private $nextInChain;

    public function setNextChain(Chain $nextChain) {
        $this->nextInChain = $nextChain;
    }

    /*
     *  @param Request $request;
     */
    public function calculate($request) {
        if ($request->getCalculationOperation() === 'divide') {


            $printArray = array(PHP_EOL . 'Divide ', $request->getNumber1() . ' / ', $request->getNumber2() . ' = ', ($request->getNumber1() / $request->getNumber2() . PHP_EOL));
            print implode('', $printArray);

        } else {
            $this->nextInChain->calculate($request);
        }
    }
}

class CofTest extends \PHPUnit_Framework_TestCase {

    public function testRemoteControl() {
        $chainCalculation1 = new AddNumbers();
        $chainCalculation2 = new SubstractNumbers();
        $chainCalculation3 = new MultiplyNumbers();
        $chainCalculation4 = new DivideNumbers();

        $chainCalculation1->setNextChain($chainCalculation2);
        $chainCalculation2->setNextChain($chainCalculation3);
        $chainCalculation3->setNextChain($chainCalculation4);

        $request = new Numbers(7, 4, 'add');
        $requestNotAdd = new Numbers(3, 1, 'substract');

        $chainCalculation1->calculate($request);
        $chainCalculation1->calculate($requestNotAdd);
    }

    protected function assertPostConditions() {
        print "---------------------------------------------------------------- \n";
    }
}
