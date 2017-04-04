<?php

namespace OrcaServices\Heartbeat\Sensor;

use OrcaServices\Heartbeat\Sensor;

/**
 * Debug Level Sensor
 */
class DebugLevel extends Sensor {

	/**
	 * @inheritdoc
	 */
	protected function _getStatus() {
		$debugLevel = \Configure::read('debug');

		return $debugLevel;
	}

}