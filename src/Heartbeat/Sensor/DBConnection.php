<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Datasource\ConnectionManager;
use Exception;
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
     * The default connection name
     */
    protected string $defaultConnectionName = 'default';

    /**
     * @inheritDoc
     */
    protected function getStatus(): bool
    {
        try {
            $connectionName = $this->getSetting('connection', $this->defaultConnectionName);

            ConnectionManager::get($connectionName)->getDriver()->connect();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}
