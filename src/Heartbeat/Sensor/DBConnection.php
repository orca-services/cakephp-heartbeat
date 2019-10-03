<?php

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Database\DriverInterface;
use OrcaServices\Heartbeat\Heartbeat\Sensor;
use Cake\Datasource\ConnectionManager;

/**
 * DB Connection Sensor
 *
 * Returns true if a connection to the database server can be established
 * or false otherwise.
 */
class DBConnection extends Sensor
{

    /**
     * @inheritdoc
     */
    protected function _getStatus()
    {
        try {
            $connectionName = $this->_getSetting('connection_name', 'default');

            /** @var DriverInterface $connection */
            $connection = ConnectionManager::get($connectionName);

            return $connection->connect();
        } catch (\Exception $e) {
            return false;
        }
    }
}
