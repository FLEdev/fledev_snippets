<?php
// incl1.php

namespace folder\to\file\ns\Animal;

class Animal {

    private $animal;

    // dependency injection
    public function __construct($animal) {
        $this->animal = $animal;
    }

    // implode text
    public function getSound() {
        return $this->animal . ' makes sound like: ' . $this->setSound() . "<br/>";
    }

    // returns static text
    private function setSound() {
        return ' animal sound ';
    }

    // public static function returning text
    public static function makeSound() {
        return 'Animal makes animal sound' . "<br />";
    }

}


// incl2.php
namespace folder\to\file\ns\Vehicle {

    class Vehicle {

        private $vehicle;

        public function __construct($vehicle) {
            $this->vehicle = $vehicle;
        }

        public function getSound() {
            return $this->vehicle . ' makes sound like: ' . $this->setSound() . "<br/>";
        }

        private function setSound() {
            return ' vrrrrm vrrrm';
        }

        public static function makeSound() {
            return 'Vehicle makes vehicle sound' . "<br />";
        }

    }

}


// index.php

// include files
require_once 'incl1.php';
require_once 'incl2.php';

// use namespace definition as aliasName
use folder\to\file\ns\Animal as nsAnimal;
use folder\to\file\ns\Vehicle as nsVehicle;

echo nsAnimal\Animal::makeSound();
// returns: Animal makes animal sound
echo nsVehicle\Vehicle::makeSound();
// returns: Vehicle makes vehicle sound

// Initialize object of type nsAnimal\Animal
$cat = new nsAnimal\Animal('Cat');
echo $cat->getSound();
// returns: Cat makes sound like: animal sound

$sameFuncName = new nsVehicle\Vehicle('Honda');
echo $sameFuncName->getSound();
// returns: Honda makes sound like: vrrrrm vrrrm