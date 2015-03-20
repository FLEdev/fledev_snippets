<?php



abstract class Player{
  public abstract function playGame();
}

// The compositum
class ChampionshipTeam extends Player{
  
	public $teamPlayers = array();
	
	// @param TeamMember
	public function addPlayer($newPlayer) {
		$this->teamPlayers[] = $newPlayer;
	}

	public function removePlayer($removingPlayer) {
		if(($key = array_search($this->teamPlayers, $removingPlayer)) !== false) {
			unset($messages[$this->teamPlayers]);
	  }
	}

	public function playGame() {
	  foreach($this->teamPlayers as $player) {
	  	$player->playGame();
	  }
	}
}

// The leaf
class TeamMember extends Player {
	
	public $position;
	public $name;
	
	public function __construct($newName, $newPosition) {
		$this->name = $newName;
		$this->position = $newPosition;
	}

	public function getName(){
		 return $this->name;
	}

	public function getPosition(){
		return $this->position;
	}
	
	public function playGame() {
		print 'Player ' . $this->getName() . ' at position ' . $this->getPosition() . PHP_EOL;
	}
}

class CompositeTest extends \PHPunit_Framework_Testcase {

	static protected $frontPlayer;
	static protected $playerDefence;
	
	public static function setUpBeforeClass() {
		self::$frontPlayer = new TeamMember('Michael', 'Front man');
		self::$playerDefence = new TeamMember('John', 'Defence');
	}
	
	// do this on after each test
	protected function assertPostConditions() {
		print "---------------------------------------------------------------- \n";
	}

	public function testTeam() {
		$oneTeam = new ChampionshipTeam();
		$oneTeam->addPlayer(self::$frontPlayer);
		$oneTeam->addPlayer(self::$playerDefence);
		$oneTeam->playGame();
	}
	
	public function testDefence() {
		self::$playerDefence->playGame();
	}
	
}