<?php

abstract class aAnimal {
    protected $skin;
    public $animalName;
    public $animalType;

    public function getAnimalName() {
        return 'The name of the animal is: ' . $this->animalName;
    }

    abstract public function setAnimalName($name);

    public static function saySomething() {
        return "\n\t" . 'tralalala' . "\n";
    }
}


class Animal extends aAnimal {

    public $animalName;

    public function animal() {
        return (TRUE);
    }

    public function setAnimalName($name) {
        $this->animalName = $name;
    }

}

$myAnimal = new Animal();
$myAnimal->setAnimalName('Lucifer');
echo $myAnimal->getAnimalName();

echo Animal::saySomething();