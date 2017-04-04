<?php

use Cake\Chronos\Chronos;
use OrcaServices\Heartbeat\Sensor\Status;

/**
 * Status Test
 *
 * @coversDefaultClass \OrcaServices\Heartbeat\Sensor\Status
 */
class StatusTest extends PHPUnit_Framework_TestCase {

	/**
	 * Tests Status class
	 *
	 * @return void
	 * @covers ::__construct
	 * @covers ::getName
	 * @covers ::getStatus
	 * @covers ::getDuration
	 * @covers ::getLastExecuted
	 * @covers ::getSeverity
	 */
	public function testStatus() {
		Chronos::setTestNow('2017-03-30 12:45:37');
		$status = new Status('Dummy Sensor', true, 0, Chronos::now(), 1);
		$this->assertInstanceOf('OrcaServices\Heartbeat\Sensor\Status', $status);
		$this->assertEquals('Dummy Sensor', $status->getName());
		$this->assertEquals(true, $status->getStatus());
		$this->assertEquals(0, $status->getDuration());
		$this->assertEquals('2017-03-30 12:45:37', $status->getLastExecuted());
		$this->assertEquals(1, $status->getSeverity());
	}
}
