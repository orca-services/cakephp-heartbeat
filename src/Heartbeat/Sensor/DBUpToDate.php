<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Exception;
use Migrations\Migrations;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * DB Up to Date Sensor
 *
 * This sensor depends on the CakePHP Migrations plugin.
 * Make sure the plugin is loaded before calling this sensor.
 *
 * @link https://github.com/cakephp/migrations/
 */
class DBUpToDate extends Sensor
{
    /**
     * Migration status indicating the migration was executed successfully
     */
    public const MIGRATION_STATUS_UP = 'up';

    /**
     * @inheritDoc
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
        } catch (Exception $exception) {
            $dbMigrated = false;
        }

        return $dbMigrated;
    }
}
