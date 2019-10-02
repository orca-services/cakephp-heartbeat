<?php

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Utility\Hash;
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
            $settings = $this->config->getSettings();
            $connectionName = Hash::get($settings, 'connection_name', 'default');
            $connection = ConnectionManager::get($connectionName);
            return $connection->connect();
        } catch (\Exception $e) {
            return false;
        }
    }

}
