<?php

use \OrcaServices\Heartbeat\Heartbeat;

/**
 * Heartbeat Test
 *
 * @coversDefaultClass \OrcaServices\Heartbeat\Heartbeat
 */
class HeartbeatTest extends PHPUnit_Framework_TestCase {

	/**
	 * Tests the check method
	 *
	 * @return void
	 * @covers ::check
	 * @covers ::_getEnabledSensors
	 * @covers ::_getSensor
	 * @covers ::getSystemStatus
	 * @covers ::getSensorStatuses
	 */
	public function testCheck() {
		$heartbeat = new Heartbeat();
		$heartbeat = $heartbeat->check();
		$this->assertInstanceOf('\OrcaServices\Heartbeat\Heartbeat', $heartbeat);

		$systemStatuses = $heartbeat->getSystemStatus();
		$this->assertInstanceOf('OrcaServices\Heartbeat\Sensor\Status', $systemStatuses);

		$sensorStatuses = $heartbeat->getSensorStatuses();
		$this->assertInstanceOf('\Cake\Collection\Collection', $sensorStatuses);
		$sensorStatuses->each(function ($sensorStatus) {
			$this->assertInstanceOf('OrcaServices\Heartbeat\Sensor\Status', $sensorStatus);
		});
	}

}
