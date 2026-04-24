<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Datasource\ConnectionManager;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * DB Connection Sensor
 *
 * Returns true if a connection to the database server can be established
 * or false otherwise.
 */
class DBConnection extends Sensor
{
    /**
     * @inheritDoc
     */
    protected function _getStatus()
    {
        try {
            return ConnectionManager::get('default')->getDriver()->connect();
        } catch (\Exception $exception) {
            return false;
        }
    }
}
