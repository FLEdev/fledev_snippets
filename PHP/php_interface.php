<?php

interface iAnimal{
    public function setSkin($surface, $color);
    public function porpulsion($porpulse);
}

class Animal implements iAnimal{

    // dependency injection
    public $animal;

    public function animal($animal){
        $this->animal = $animal;
        return (TRUE);
    }

    public function setSkin($surface, $color){
        return 'The animal has a surface like ' . $surface . ' and color: ' . $color;
    }

    // arguments can have different names
    public function porpulsion($porpulsionName){
        return $this->animal . ' moves by ' . $porpulsionName;
    }
}

$myAnimal = new Animal('cat');
echo $myAnimal -> porpulsion('feed and jumping');