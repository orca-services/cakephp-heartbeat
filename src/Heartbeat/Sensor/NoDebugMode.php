<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Core\Configure;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * No Debug Mode Sensor
 */
class NoDebugMode extends Sensor
{
    /**
     * @inheritDoc
     */
    protected function getStatus(): bool
    {
        return (bool)Configure::read('debug') === false;
    }

    /**
     * @inheritDoc
     */
    protected function getStatusMessage(bool $status): string
    {
        return $status ? __d('Heartbeat', 'ENABLED') : __d('Heartbeat', 'DISABLED');
    }
}
