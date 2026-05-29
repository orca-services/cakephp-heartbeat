<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Core\Configure;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * Debug Level Sensor
 */
class DebugMode extends Sensor
{
    /**
     * @inheritDoc
     */
    protected function _getStatus(): mixed
    {
        return (string)Configure::read('debug');
    }
}
