<?php

use Cake\Chronos\Chronos;
use OrcaServices\Heartbeat\Sensor;

class DummySensor extends Sensor {

	/**
	 * @inheritDoc
	 */
	protected function _getStatus() {
		return true;
	}

}

/**
 * Sensor Test
 *
 * @coversDefaultClass \OrcaServices\Heartbeat\Sensor
 */
class SensorTest extends PHPUnit_Framework_TestCase {

	/**
	 * Tests the constructor
	 *
	 * @return void
	 * @covers ::__construct
	 */
	public function testConstructor() {
		$sensorName = 'Dummy Sensor';
		$sensorConfig = array (
			'enabled' => true,
			'severity' => 1,
			'class' => 'DummySensor',
		);
		$sensorConfig = new Sensor\Config($sensorName, $sensorConfig);
		$sensorClassName = $sensorConfig->getClass();
		/** @var Sensor $sensor */
		$sensor = new $sensorClassName($sensorConfig);
		$this->assertAttributeEquals($sensorConfig, 'config', $sensor);
	}

	/**
	 * Tests the constructor
	 *
	 * @return void
	 * @covers ::getStatus
	 * @covers ::_getStatus
	 */
	public function testGetStatus() {
		Chronos::setTestNow('2017-03-30 12:45:37');
		$sensorName = 'Dummy Sensor';
		$sensorConfig = array (
			'enabled' => true,
			'severity' => 1,
			'class' => 'DummySensor',
		);
		$sensorConfig = new Sensor\Config($sensorName, $sensorConfig);
		$sensorClassName = $sensorConfig->getClass();
		/** @var Sensor $sensor */
		$sensor = new $sensorClassName($sensorConfig);
		$status = $sensor->getStatus();
		$this->assertInstanceOf('OrcaServices\Heartbeat\Sensor\Status', $status);
		$this->assertEquals('Dummy Sensor', $status->getName());
		$this->assertEquals(true, $status->getStatus());
		$this->assertEquals(0, $status->getDuration());
		$this->assertEquals('2017-03-30 12:45:37', $status->getLastExecuted());
		$this->assertEquals(1, $status->getSeverity());
	}
}
