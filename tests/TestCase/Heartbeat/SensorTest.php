<?php

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat;

use Cake\Chronos\Chronos;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Test\TestCase\Sensor\DummySensor;

/**
 * Sensor Test
 *
 * @coversDefaultClass \OrcaServices\Heartbeat\Heartbeat\Sensor
 */
class SensorTest extends TestCase
{
    /**
     * Tests the constructor
     *
     * @return void
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $sensorName = 'Dummy Sensor';
        $sensorConfig = [
            'enabled' => true,
            'severity' => 1,
            'class' => DummySensor::class,
        ];
        $sensorConfig = new Config($sensorName, $sensorConfig);
        $sensorClassName = $sensorConfig->getClass();
        /** @var Sensor $sensor */
        $sensor = new $sensorClassName($sensorConfig);
        $this->assertAttributeEquals($sensorConfig, 'config', $sensor);
    }

    /**
     * Tests the constructor
     *
     * @return void
     * @covers ::getStatus
     * @covers ::_getStatus
     */
    public function testGetStatus()
    {
        Chronos::setTestNow('2017-03-30 12:45:37');
        $sensorName = 'Dummy Sensor';
        $sensorConfig = [
            'enabled' => true,
            'severity' => 1,
            'class' => DummySensor::class,
        ];
        $sensorConfig = new Config($sensorName, $sensorConfig);
        $sensorClassName = $sensorConfig->getClass();
        /** @var Sensor $sensor */
        $sensor = new $sensorClassName($sensorConfig);
        $status = $sensor->getStatus();
        $this->assertInstanceOf(Sensor\Status::class, $status);
        $this->assertEquals('Dummy Sensor', $status->getName());
        $this->assertEquals(true, $status->getStatus());
        $this->assertEquals(0, $status->getDuration());
        $this->assertEquals('2017-03-30 12:45:37', $status->getLastExecuted());
        $this->assertEquals(1, $status->getSeverity());
    }

    /**
     * Tests whether the check result was fetched from cache when cache is disabled
     *
     * @return void
     * @covers ::_getCachedStatus
     * @covers ::_getNonCachedStatus
     */
    public function testWasCheckCachedWhenCacheDisabled()
    {
        Chronos::setTestNow('2017-03-30 12:45:37');
        $sensorName = 'Uncached Sensor';
        $sensorConfig = [
            'enabled' => true,
            'severity' => 1,
            'class' => DummySensor::class,
            'cached' => false
        ];
        $sensorConfig = new Config($sensorName, $sensorConfig);
        $sensorClassName = $sensorConfig->getClass();

        /** @var DummySensor $sensor */
        $sensor = new $sensorClassName($sensorConfig);
        $status = $sensor->getStatus();

        $this->assertFalse($status->wasCheckCached());
        $status = $sensor->getStatus();
        $this->assertFalse($status->wasCheckCached());
    }
}
