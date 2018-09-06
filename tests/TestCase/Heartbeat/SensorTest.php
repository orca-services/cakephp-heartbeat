<?php

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat;

use Cake\Chronos\Chronos;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

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
        $sensorConfig = new Sensor\Config($sensorName, $sensorConfig);
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
        $this->markTestIncomplete('TODO: Fix this test. Something about cache seems broken.');

        Chronos::setTestNow('2017-03-30 12:45:37');
        $sensorName = 'Dummy Sensor';
        $sensorConfig = [
            'enabled' => true,
            'severity' => 1,
            'class' => DummySensor::class,
        ];
        $sensorConfig = new Sensor\Config($sensorName, $sensorConfig);
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
}
