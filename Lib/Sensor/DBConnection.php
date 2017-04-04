<?php

namespace OrcaServices\Heartbeat\Sensor;

\App::uses('ConnectionManager', 'Model');

use OrcaServices\Heartbeat\Sensor;

/**
 * DB Connection Sensor
 */
class DBConnection extends Sensor {

	/**
	 * @inheritdoc
	 */
	protected function _getStatus() {
		try {
			\ConnectionManager::getDataSource('default');
			$hasDBConnection = true;
		} catch (\Exception $e) {
			$hasDBConnection = false;
		}

		return $hasDBConnection;
	}

}