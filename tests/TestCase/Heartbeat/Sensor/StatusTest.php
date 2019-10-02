<?php

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat\Sensor;

use Cake\Chronos\Chronos;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;
use OrcaServices\Heartbeat\Test\TestCase\Heartbeat\DummySensor;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    /**
     * Tests Status class
     *
     * @return void
     * @covers ::__construct
     * @covers ::getName
     * @covers ::getStatus
     * @covers ::getDuration
     * @covers ::getLastExecuted
     * @covers ::getSeverity
     */
    public function testStatus()
    {
        Chronos::setTestNow('2017-03-30 12:45:37');
        $status = new Status('Dummy Sensor', true, 0, Chronos::now(), 1);
        $this->assertInstanceOf(Status::class, $status);
        $this->assertEquals('Dummy Sensor', $status->getName());
        $this->assertEquals(true, $status->getStatus());
        $this->assertEquals(0, $status->getDuration());
        $this->assertEquals('2017-03-30 12:45:37', $status->getLastExecuted());
        $this->assertEquals(1, $status->getSeverity());
    }

    /**
     * Tests whether the check result was fetched from cache or by running the check now
     *
     * @return void
     * @covers Status::wasCheckCached
     */
    public function testWasCheckCached()
    {
        Chronos::setTestNow('2017-03-30 12:45:37');
        $sensorName = 'Cache Sensor';
        $sensorConfig = [
            'enabled' => true,
            'severity' => 1,
            'class' => DummySensor::class,
            'cached' => "+1 seconds"
        ];
        $sensorConfig = new Config($sensorName, $sensorConfig);
        $sensorClassName = $sensorConfig->getClass();

        /** @var DummySensor $sensor */
        $sensor = new $sensorClassName($sensorConfig);
        $status = $sensor->getStatus();

        // Assert that result was not cached
        $this->assertFalse($status->wasCheckCached());

        // Get status again and assert that result was cached
        /** @var DummySensor $sensor */
        $sensor = new $sensorClassName($sensorConfig);
        $status = $sensor->getStatus();
        $this->assertTrue($status->wasCheckCached());
    }
}
