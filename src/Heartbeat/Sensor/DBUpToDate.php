<?php

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Migrations\Migrations;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * DB Up to Date Sensor
 *
 * This sensor depends on the CakePHP Migrations plugin
 *
 * @link https://github.com/cakephp/migrations/
 */
class DBUpToDate extends Sensor
{
    /**
     * Migration status indicating the migration was executed successfully
     */
    const MIGRATION_STATUS_UP = 'up';

    /**
     * @inheritdoc
     */
    protected function _getStatus()
    {
        $dbMigrated = true;
        try {
            $migrations = new Migrations();
            $status = $migrations->status();
            $lastStatus = array_pop($status);
            if ($lastStatus['status'] !== self::MIGRATION_STATUS_UP) {
                $dbMigrated = false;
            }
        } catch (\Exception $e) {
            $dbMigrated = false;
        }

        return $dbMigrated;
    }

}
