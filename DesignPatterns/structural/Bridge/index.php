<?php

abstract class RemoteControl {
  
	private $volumeLevel = 0;
	public $deviceState;
	public $deviceMaxSetting;
	
	public abstract function buttonFivePress();
	public abstract function buttonSixPress();
	
	public function getDeviceState() {
	  print 'Device is at: ' . $this->deviceState . "\n";
	}
	
	public function buttonSevenPress() {
	  $this->volumeLevel--;
	  print 'Lowered volume level to ' . $this->volumeLevel .  "\n";
	}
	
	public function buttonEightPress() {
		$this->volumeLevel++;
		print 'Highered volume level to ' . $this->volumeLevel .  "\n";
	}
}

class TvRemote extends RemoteControl {
  
	public function __construct($newDeviceState, $newMaxSetting) {
	  $this->deviceState = $newDeviceState;
	  $this->deviceMaxSetting = $newMaxSetting;
	}
	
	public function buttonFivePress(){
		$this->deviceState--;
		print 'Changed channel to ' . $this->deviceState .  "\n";
	}
	
	public function buttonSixPress(){
		$this->deviceState++;
		print 'Changed channel to ' . $this->deviceState .  "\n";
	}
}

abstract class RemoteButton {

  public function getDeviceState() {
  	$this->device->getDeviceState();
  }
  
  public function buttonFivePress() {
    $this->device->buttonFivePress();
  }
  
  public function buttonSixPress() {
  	$this->device->buttonSixPress();
  }
  
  public abstract function buttonNinePress();
}

class TvRemoteMute extends RemoteButton {

	//@type RemoteControl
	public $device;
  public function __construct($newDevice) {
    $this->device = $newDevice;
  }
	
  public function buttonNinePress() {
    print 'TV was muted' . "\n";
  }
}

class DvdRemoteMute extends RemoteButton {
	public function buttonNinePress() {
		print 'Device was paused' . "\n";
	}
	
	public function buttonFivePress() {
		$this->device->buttonFivePress();
	}
	
	public function buttonSixPress() {
		$this->device->buttonSixPress();
	}
	
}

class BridgeTest extends \PHPunit_Framework_Testcase {

	// do this on after each test
	protected function assertPostConditions() {
		print "---------------------------------------------------------------- \n";
	}
	
	public function testTvChannelSwitch() {
	  $tvRemoteMute = new TvRemoteMute(new TvRemote(1, 59));
	  $tvRemoteMute->buttonSixPress();
	  $tvRemoteMute->buttonSixPress();
	  $tvRemoteMute->buttonFivePress();
	}
	
	public function testTvChannelMute() {
		$tvRemoteMute = new TvRemoteMute(new TvRemote(1, 59));
		$tvRemoteMute->buttonNinePress();
	}
}