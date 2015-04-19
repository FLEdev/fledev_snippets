<?php


interface TerrestrianTransportation {
	public function drive();
	public function enbus();
	public function getGasoline();
}

class HermesTransportation implements TerrestrianTransportation {
	public function drive() {
		print 'Driving with truck on paved road.' . "\n";
	}
	
	public function enbus() {
		print 'Loading goods on Truck.' . "\n";
	}
	
	public function getGasoline() {
		print 'In order to drive the Truck we need Gassoline.' . "\n";
	}
}


interface NauticalTransportation {
	public function floatShip();
	public function embark();
	public function getDiesel();
}

class FloydTransportation implements NauticalTransportation {
	public function floatShip() {
		print 'Floating on water on a big container Ship.' . "\n";
	}

	public function embark() {
		print 'Loading goods on Ship.' . "\n";
	}

	public function getDiesel() {
		print 'In order to float the Ship we need Diesel.' . "\n";
	}
}

interface AerialTransportation {
	public function fly();
	public function enplane();
	public function getKerosene();
}

class AirbusTransportation implements AerialTransportation {
	public function fly() {
		print 'Flying over the clouds with on a plane.' . "\n";
	}

	public function enplane() {
		print 'Loading goods on Plane.' . "\n";
	}

	public function getKerosene() {
		print 'In order to fly the plane we need Kerosene.' . "\n";
	}
}

interface TransportationAdapterInterface {
	public function getMovement();
	public function getLoad();
	public function getFuel();
}

class TransportationAdapter implements TransportationAdapterInterface{
	private $transportation;
	private $transportationFeatures;
	
	public function __construct($newTransportation) {
		$this->transportation = $newTransportation;
		$this->transportationFeatures = $this->getTransportationFeaturesMap($this->transportation);
	}
	
	public function getMovement() {
		return $this->transportation->{$this->transportationFeatures['movement']}();
	}
	
	public function getLoad() {
		return $this->transportation->{$this->transportationFeatures['load']}();
	}
	
	public function getFuel() {
		return $this->transportation->{$this->transportationFeatures['fuel']}();
	}

	private function getTransportationFeaturesMap($transport) {
		if($transport instanceof TerrestrianTransportation) {
				return array('movement' => 'drive', 'load' => 'enbus', 'fuel' => 'getGasoline');
		} elseif($transport instanceof NauticalTransportation) {
				return array('movement' => 'floatShip', 'load' => 'enbark', 'fuel' => 'getDiesel');
		} elseif($transport instanceof AerialTransportation) {
				return array('movement' => 'fly', 'load' => 'enplane', 'fuel' => 'getKerosene');
		} else {
			return array();
		}
	}
}

class AdapterTest extends \PHPunit_Framework_Testcase {

	static protected $terrestrian;
	static protected $nautical;
	static protected $aerial;
	
	public static function setUpBeforeClass() {
		self::$terrestrian = new HermesTransportation();
		self::$nautical = new FloydTransportation();
		self::$aerial = new AirbusTransportation();
	}

	// do this on after each test
	protected function assertPostConditions() {
		print "---------------------------------------------------------------- \n";
	}
	
	public function testShowMovementShip() {
		$transportationAdapter = new TransportationAdapter(self::$nautical);
		$transportationAdapter->getMovement();
	}
	
	public function testShowFuelPlane() {
		$transportationAdapter = new TransportationAdapter(self::$aerial);
		$transportationAdapter->getFuel();
	}
	
	public function testShowLoad() {
		$transportationAdapter = new TransportationAdapter(self::$terrestrian);
		$transportationAdapter->getMovement();
	}
}