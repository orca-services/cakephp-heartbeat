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
     * @inheritDoc
     */
    protected array $defaultSettings = [
        'connection' => 'default',
    ];

    /**
     * @inheritDoc
     */
    protected function getStatus(): bool
    {
        try {
            $connectionName = $this->getSetting('connection');

            ConnectionManager::get($connectionName)->getDriver()->connect();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    protected function getStatusMessage(bool $status): string
    {
        return $status ? __d('Heartbeat', 'OK') : __d('Heartbeat', 'FAILED');
    }
}
