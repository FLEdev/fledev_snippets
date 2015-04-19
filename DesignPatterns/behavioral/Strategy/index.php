<?php

// Strategy bound
interface SortStrategy {
    public function sort($array);
}

// Strategy member MergeSort
class MergeSort implements SortStrategy {
    public function sort($array) {
        if (count($array) == 1) {
            return $array;
        }
        $mid = count($array) / 2;
        $left = array_slice($array, 0, $mid);
        $right = array_slice($array, $mid);
        $left = $this->sort($left);
        $right = $this->sort($right);
        return $this->merge($left, $right);
    }

    private function merge($left, $right) {
        $res = array();
        while (count($left) > 0 && count($right) > 0) {
            if ($left[0] > $right[0]) {
                $res[] = $right[0];
                $right = array_slice($right, 1);
            } else {
                $res[] = $left[0];
                $left = array_slice($left, 1);
            }
        }
        while (count($left) > 0) {
            $res[] = $left[0];
            $left = array_slice($left, 1);
        }
        while (count($right) > 0) {
            $res[] = $right[0];
            $right = array_slice($right, 1);
        }
        return $res;
    }

}

// Strategy member QuickSort
class QuickSort implements SortStrategy {
    public function sort($array) {
        sort($array);
        return $array;
    }
}

// --------------------------------------------
// Strategy implementation
class StrategyImplementation {

    protected $sortArray;
    protected $sortClass;

    // Strategy implementation
    public function doSort() {
        // Our strategy is that if array size exceeds 100 we use the appropriate implementation
        if (count($this->sortArray) > 100) {
            $this->sortClass = new MergeSort();
        } else {
            $this->sortClass = new QuickSort();
        }
        return  $this->sortClass->sort($this->sortArray);
    }

    public function getHandler() {
        return get_class($this->sortClass);
    }

    public function setArray($newArray) {
        $this->sortArray = $newArray;
    }
}

// ----------------------------------------------------------

class StateTest extends \PHPunit_Framework_Testcase {

    public function testSmallArray() {
        $myArray = array(17, 3, 1, 23, 5, 7, 11, 13, 19);
        $sortInstance = new StrategyImplementation();
        $sortInstance->setArray($myArray);
        $sortedArray = $sortInstance->doSort();
        print 'Sort responsible is: ' . $sortInstance->getHandler() . PHP_EOL;
        print_r($sortedArray);
    }

    public function testBigArray() {
        $myArray = array(17, 3, 1, 14, 5, 7, 11, 13, 19, 15, 6, 12, 157, 536, 615, 134, 512, 127, 161, 183, 179, 135, 267, 172, 217, 23, 21, 214, 25, 27, 211, 213, 219, 215, 26, 212, 817, 83, 81, 814, 85, 87, 811, 813, 819, 815, 86, 812, 417, 43, 41, 414, 54, 47, 411, 413, 419, 415, 46, 412, 517, 53, 51, 514, 55, 57, 511, 513, 519, 515, 56, 512, 717, 73, 71, 714, 75, 77, 711, 713, 719, 715, 76, 712, 317, 33, 31, 314, 35, 37, 311, 313, 319, 315, 36, 312, 917, 93, 91, 914, 95, 97, 911, 913, 919, 915, 96, 912, 171, 135, 111, 141, 51, 71, 111, 113, 191, 151, 61, 121, 617, 63, 61, 614, 65, 67, 611, 613, 619, 615, 66, 612);
        $sortInstance = new StrategyImplementation();
        $sortInstance->setArray($myArray);
        $sortedArray = $sortInstance->doSort();
        print 'Sort responsible is: ' . $sortInstance->getHandler() . PHP_EOL;
        print_r($sortedArray);
    }

    // do this on after each test
    protected function assertPostConditions() {
        print "----------------------------------------------------------------" . PHP_EOL;
    }
}
