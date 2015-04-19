<?php

class Player {
  public $data;
    public function __construct(array $info) {
      $this->data = $info;
    }
}


$player = new Player(array('strength' => 10, 'dex' => 15));
echo 'Default strength: ' . $player->data['strength'] . PHP_EOL;
echo 'Default dex: ' . $player->data['dex'] . PHP_EOL;
// ----------------------------------------------------
// Let's extend this ....

abstract class PlayerDecoration {
  abstract public function add($int);
}

class PlayerDecorateStrength extends PlayerDecoration {
  public $player;
  public function __construct(Player $player) {
    $this->player = $player;
  }

  public function add($int) {
    $this->player->data['strength'] += $int;
  }
}

class PlayerDecorateDex extends PlayerDecoration {
  public $player;

  public function __construct(Player $player) {
    $this->player = $player;
  }

  public function add($int) {
    $this->player->data['dex'] += $int;
  }
}

class DecoratorTest extends \PHPunit_Framework_Testcase {

  public static function setUpBeforeClass() {
  }

  // do this on after each test
  protected function assertPostConditions() {
    print "---------------------------------------------------------------- \n";
  }

  public function testPlayerExtension() {
    $somePlayer = new Player(array('strength' => 10, 'dex' => 15));

    $playerStrength = new PlayerDecorateStrength($somePlayer);
     echo 'Old strength: ' .$playerStrength->player->data['strength'] . PHP_EOL;
    $playerStrength->add(3);
    echo 'Increased strength: ' .$playerStrength->player->data['strength'] . PHP_EOL;
  }
}


