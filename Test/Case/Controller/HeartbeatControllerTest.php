<?php
App::uses('HeartbeatController', 'Heartbeat.Controller');

use Cake\Chronos\Chronos;

/**
 * Heartbeat Controller Test
 *
 * @coversDefaultClass HeartbeatController
 * @todo Cover the JSON page by introspecting the generated JSON.
 */
class HeartbeatControllerTest extends ControllerTestCase {

	/**
	 * Tests index
	 *
	 * @return void
	 * @covers ::index
	 */
	public function testIndex() {
		Chronos::setTestNow('2017-03-30 12:45:37');

		$result = $this->testAction(
				array(
					'plugin' => 'heartbeat',
					'controller' => 'Heartbeat',
					'action' => 'index',
				),
			array(
				'return' => 'vars',
			)
		);

		$systemStatus = $result['systemStatus'];
		$this->assertInstanceOf('OrcaServices\Heartbeat\Sensor\Status', $systemStatus);

		/** @var \Cake\Collection\Collection $sensorStatuses */
		$sensorStatuses = $result['sensorStatuses'];
		$this->assertInstanceOf('\Cake\Collection\Collection', $sensorStatuses);
		$sensorStatuses->each(function ($sensorStatus) {
			$this->assertInstanceOf('OrcaServices\Heartbeat\Sensor\Status', $sensorStatus);
		});
	}
}
