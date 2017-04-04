<?php

namespace OrcaServices\Heartbeat\Sensor;

\App::uses('MigrationVersion', 'Migrations.Lib');

use OrcaServices\Heartbeat\Sensor;

/**
 * DB Up to Date Sensor
 */
class DBUpToDate extends Sensor {

	/**
	 * @inheritdoc
	 */
	protected function _getStatus() {
		$dbMigrated = true;
		try {
			$migrationVersion = new \MigrationVersion(array());
			$currentMigrationVersion = $migrationVersion->getVersion('app');
			$latestMigrationVersion = $migrationVersion->getMapping('app');
			$latestMigrationVersion = end($latestMigrationVersion);
			$latestMigrationVersion = $latestMigrationVersion['version'];

			if ($currentMigrationVersion !== $latestMigrationVersion) {
				$dbMigrated = false;
			}
		} catch (\Exception $e) {
			$dbMigrated = false;
		}

		return $dbMigrated;
	}

}
