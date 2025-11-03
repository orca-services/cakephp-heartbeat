<?php

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Core\Configure;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * Debug Level Sensor
 */
class DebugMode extends Sensor
{
    /**
     * {@inheritdoc}
     */
    protected function _getStatus()
    {
        return (string)Configure::read('debug');
    }
}
