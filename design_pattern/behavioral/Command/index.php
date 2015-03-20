<?php

interface ElectronicDevice {
    public function on();

    public function off();

    public function volumeUp();

    public function volumeDown();
}


// At this point, thing about the decorator pattern how the object functionality could be made
// more flexible by renaming the class and modelling the object based on the needs.
class MultimediaDevice implements ElectronicDevice {

    private $volume = 0;
    private $state = false;
    private $deviceName;

    /*
    * @param ElectronicDevice $deviceName
    */
    public function __construct($deviceName) {
        $this->deviceName = $deviceName;
    }

    public function on() {
        print $this->deviceName . ' is ON' . PHP_EOL;
    }

    public function off() {
        print $this->deviceName . ' is OFF' . PHP_EOL;
    }

    public function volumeUp() {
        if ($this->state) {
            $this->volume++;
            print $this->deviceName . ' volume goes UP to: ' . $this->volume . PHP_EOL;
        } else {
            print $this->deviceName . ' has to be switched ON first ' . PHP_EOL;
        }
    }

    public function volumeDown() {
        if ($this->state) {
            $this->volume--;
            print $this->deviceName . ' volume goes Down to: ' . $this->volume . PHP_EOL;
        } else {
            print $this->deviceName . ' has to be switched ON first ' . PHP_EOL;
        }
    }

    public function setState($newState) {
        $this->state = $newState;
    }
}


interface Command {
    public function execute();
}


// reusing the similar classes
class ExecuteDeviceOn implements Command {
    private $theDevice;

    /*
    * @param ElectronicDevice $newDevice
    */
    public function __construct(ElectronicDevice $newDevice) {
        $this->theDevice = $newDevice;
    }

    public function execute() {
        $this->theDevice->setState(true);
        $this->theDevice->on();
    }
}


class ExecuteDeviceOff implements Command {
    private $theDevice;

    /*
    * @param ElectronicDevice $newDevice
    */
    public function __construct(ElectronicDevice $newDevice) {
        $this->theDevice = $newDevice;
    }

    public function execute() {
        $this->theDevice->setState(false);
        $this->theDevice->off();
    }
}

class ExecuteVolumeUp implements Command {
    private $theDevice;

    /*
    * @param ElectronicDevice $newDevice
    */
    public function __construct(ElectronicDevice $newDevice) {
        $this->theDevice = $newDevice;
    }

    public function execute() {
        $this->theDevice->volumeUp();
    }
}


class ExecuteVolumeDown implements Command {
    private $theDevice;

    /*
    * @param ElectronicDevice $newDevice
    */
    public function __construct(ElectronicDevice $newDevice) {
        $this->theDevice = $newDevice;
    }

    public function execute() {
        $this->theDevice->volumeDown();
    }
}

class ExecuteAllDevicesOff implements Command {
    private $theDevices;

    /*
    * @param ElectronicDevice $newDevice
    */
    public function __construct($newDevices) {
        $this->theDevices = $newDevices;
        $this->execute();
    }

    public function execute() {
        foreach ($this->theDevices as $device) {
            $switchOffCommand = new ExecuteDeviceOff($device);
            $switchOffCommand->execute();
        }
    }
}

// caller of the functionality containing objects (classes)
class DeviceButton {
    private $theCommand;

    /*
    * @param Command $newCommand
    */
    public function __construct($newCommand) {
        $this->theCommand = $newCommand;
    }

    public function press() {
        $this->theCommand->execute();
    }

}

class TvRemote {
    public static function getDevice() {
        return new MultimediaDevice('Television');
    }
}


class RadioRemote {
    public static function getDevice() {
        return new MultimediaDevice('Radio');
    }
}


class CommandTest extends \PHPUnit_Framework_TestCase {

    public function testRemoteControl() {
        $televisionRemote = TvRemote::getDevice();

        $tvOnCommand = new ExecuteDeviceOn($televisionRemote);
        $TvOnButton = new DeviceButton($tvOnCommand);

        $volumeUpCommand = new ExecuteVolumeUp($televisionRemote);
        $TvVolumeUpButton = new DeviceButton($volumeUpCommand);

        $tvOffCommand = new ExecuteDeviceOff($televisionRemote);
        $TvOffButton = new DeviceButton($tvOffCommand);

        $TvOnButton->press();
        $TvVolumeUpButton->press();
        $TvVolumeUpButton->press();
        $TvOffButton->press();
        $TvVolumeUpButton->press();
    }

    public function testSwitchAllOff() {
        $devices = array();
        $devices['television'] = TvRemote::getDevice();
        $devices['radio'] = RadioRemote::getDevice();
        $turnOffCommand = new ExecuteAllDevicesOff($devices);
    }

    protected function assertPostConditions() {
        print "---------------------------------------------------------------- \n";
    }
}
