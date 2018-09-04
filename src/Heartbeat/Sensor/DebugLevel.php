<?php

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Core\Configure;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * Debug Level Sensor
 */
class DebugLevel extends Sensor {

	/**
	 * @inheritdoc
	 */
	protected function _getStatus() {
		$debugLevel = (string)Configure::read('debug');

		return $debugLevel;
	}

}
