<?php

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Database\DriverInterface;
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
            $connectionName = $this->getConnectionName();

            /** @var DriverInterface $connection */
            $connection = ConnectionManager::get($connectionName);

            return $connection->connect();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the connection name
     *
     * Either the one configured or simply the default one.
     *
     * @return string The name of the connection to check.
     */
    protected function getConnectionName(): string
    {
        $settings = $this->config->getSettings();
        $connectionName = Hash::get($settings, 'connection_name', 'default');

        return $connectionName;
    }
}
