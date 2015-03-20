<?php
// animal.php
require_once('C:\wamp\bin\php\php5.4.3\pear\PHPUnit\Autoload.php');

class Animal
{
    public $animal;
    protected $output;

    public function animal($animal){
        $this->animal = $animal;
    }

    public function porpulsion(){
        if($this->animal == 'fish'){
            return ('water');
        } elseif ($this->animal == 'bird') {
            return ('air');
        }
        return (FALSE);
    }

    public function bodyCoverage(){
        return (TRUE);
    }

    public function animalOutput() {
        $this->output = '<div class="top"><div class="inside">' . $this->animal . '</div></div>';
        return $this->output;
    }
}


// animal_test.php

require_once('animal.php');

class AnimalTest extends PHPUnit_Framework_TestCase
{
    public $test;


    public function setUp(){
        $this->test = new Animal('fish');
    }

    public function testPorpulsion(){
        $animalPorpulsion = $this->test->porpulsion();
        $this->assertEquals($animalPorpulsion, 'water');
    }

    public function testBodyCoverage(){

    }

    public function testNumberOfLimbs() {

    }

    public function testAnimalOutput() {
        $animalPorpulsion = $this->test->animalOutput();
        $matcher = array(
            'attributes' => array('class' => 'inside'),
            'content' => 'fish',
            'ancestor' => array('attributes' => array('class' => 'top'))
        );
        $this->assertTag($matcher, $animalPorpulsion);
    }
}