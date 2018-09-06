<?php

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use OrcaServices\Heartbeat\Heartbeat\Sensor;
use Cake\Datasource\ConnectionManager;

/**
 * DB Connection Sensor
 */
class DBConnection extends Sensor
{

    /**
     * @inheritdoc
     */
    protected function _getStatus()
    {
        try {
            ConnectionManager::get('default');
            $hasDBConnection = true;
        } catch (\Exception $e) {
            $hasDBConnection = false;
        }

        return $hasDBConnection;
    }

}
