<?php

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Migrations\Migrations;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * DB Up to Date Sensor
 */
class DBUpToDate extends Sensor
{

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
            if ($lastStatus['status'] === 'down') {
                $dbMigrated = false;
            }
        } catch (\Exception $e) {
            $dbMigrated = false;
        }

        return $dbMigrated;
    }

}
