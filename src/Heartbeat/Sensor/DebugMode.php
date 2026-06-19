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
    protected function getStatus(): bool
    {
        return (bool)Configure::read('debug');
    }
}
