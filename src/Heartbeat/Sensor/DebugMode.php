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

    /**
     * @inheritDoc
     */
    protected function getStatusMessage(bool $status): string
    {
        return $status ? __d('Heartbeat', 'OK') : __d('Heartbeat', 'FAILED');
    }
}
