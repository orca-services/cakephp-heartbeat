<?php

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat;

use Cake\Collection\Collection;
use OrcaServices\Heartbeat\Heartbeat\Heartbeat;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;
use PHPUnit\Framework\TestCase;

class HeartbeatTests extends TestCase
{
    /**
     * Tests the check method
     *
     * @return void
     * @covers ::check
     * @covers ::_getEnabledSensors
     * @covers ::_getSensor
     * @covers ::getSystemStatus
     * @covers ::getSensorStatuses
     */
    public function testCheck()
    {
        $heartbeat = new Heartbeat();
        $heartbeat = $heartbeat->check();
        $this->assertInstanceOf(Heartbeat::class, $heartbeat);
        $systemStatuses = $heartbeat->getSystemStatus();
        $this->assertInstanceOf(Status::class, $systemStatuses);
        $sensorStatuses = $heartbeat->getSensorStatuses();
        $this->assertInstanceOf(Collection::class, $sensorStatuses);
        $sensorStatuses->each(function ($sensorStatus) {
            $this->assertInstanceOf(Status::class, $sensorStatus);
        });
    }
}
