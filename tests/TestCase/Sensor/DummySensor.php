<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Sensor;

use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * A Dummy Sensor for testing purposes
 */
class DummySensor extends Sensor
{
    /**
     * @inheritDoc
     */
    protected function getStatus(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function getStatusMessage(bool $status): string
    {
        return $status ? __d('Heartbeat', 'OK') : __d('Heartbeat', 'FAILED');
    }
}
