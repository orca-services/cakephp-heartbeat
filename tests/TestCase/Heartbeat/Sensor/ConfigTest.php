<?php

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat\Sensor;

use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Test\TestCase\Heartbeat\DummySensor;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * Tests Config class
     *
     * @return void
     * @covers ::__construct
     * @covers ::setName
     * @covers ::setEnabled
     * @covers ::setSeverity
     * @covers ::setClass
     * @covers ::getName
     * @covers ::getEnabled
     * @covers ::getSeverity
     * @covers ::getClass
     */
    public function testCreateConfig()
    {
        $sensorName = 'Dummy Sensor';
        $sensorConfigArray = [
            'enabled' => true,
            'severity' => 1,
            'class' => DummySensor::class,
        ];
        $sensorConfig = new Config($sensorName, $sensorConfigArray);
        $this->assertEquals($sensorName, $sensorConfig->getName());
        $this->assertEquals($sensorConfigArray['enabled'], $sensorConfig->getEnabled());
        $this->assertEquals($sensorConfigArray['severity'], $sensorConfig->getSeverity());
        $this->assertEquals($sensorConfigArray['class'], $sensorConfig->getClass());
    }

    /**
     * Tests Config class
     *
     * @return void
     * @covers ::__construct
     * @covers ::setName
     * @covers ::setEnabled
     * @covers ::setSeverity
     * @covers ::setClass
     * @covers ::getName
     * @covers ::getEnabled
     * @covers ::getSeverity
     * @covers ::getClass
     */
    public function testDefaultConfig()
    {
        $sensorName = 'Dummy Sensor';
        $sensorConfigArray = [];
        $sensorConfig = new Config($sensorName, $sensorConfigArray);
        $this->assertEquals($sensorName, $sensorConfig->getName());
        $this->assertEquals(true, $sensorConfig->getEnabled());
        $this->assertEquals(2, $sensorConfig->getSeverity());
        $this->assertEquals(null, $sensorConfig->getClass());
    }

    /**
     * Test Invalid Severity
     *
     * @return void
     * @covers ::setSeverity
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidSeverity()
    {
        $sensorName = 'Dummy Sensor';
        $sensorConfigArray = [
            'enabled' => true,
            'severity' => 999999,
            'class' => DummySensor::class,
        ];
        new Config($sensorName, $sensorConfigArray);
    }

    /**
     * Test Invalid Enabled
     *
     * @return void
     * @covers ::setEnabled
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidEnabled()
    {
        $sensorName = 'Dummy Sensor';
        $sensorConfigArray = [
            'enabled' => 3,
            'severity' => 1,
            'class' => DummySensor::class,
        ];
        new Config($sensorName, $sensorConfigArray);
    }
}
