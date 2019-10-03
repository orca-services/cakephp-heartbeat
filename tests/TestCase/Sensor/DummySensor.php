<?php

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
    protected function _getStatus()
    {
        return true;
    }
}
