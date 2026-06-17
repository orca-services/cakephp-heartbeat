<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat\Sensor;

use Cake\TestSuite\TestCase;
use InvalidArgumentException;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Test\TestCase\Sensor\DummySensor;

/**
 * Config Tests
 *
 * @coversDefaultClass \OrcaServices\Heartbeat\Heartbeat\Sensor\Config
 */
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
     * @covers ::setSettings
     * @covers ::getName
     * @covers ::getEnabled
     * @covers ::getSeverity
     * @covers ::getClass
     * @covers ::getSettings
     */
    public function testCreateConfig(): void
    {
        $sensorName = 'Dummy Sensor';
        $sensorConfigArray = [
            'enabled' => true,
            'severity' => 1,
            'class' => DummySensor::class,
            'cached' => true,
            'settings' => [
                'connection' => 'test',
            ],
        ];
        $sensorConfig = new Config($sensorName, $sensorConfigArray);
        static::assertEquals($sensorName, $sensorConfig->getName());
        static::assertEquals($sensorConfigArray['enabled'], $sensorConfig->getEnabled());
        static::assertEquals($sensorConfigArray['severity'], $sensorConfig->getSeverity());
        static::assertEquals($sensorConfigArray['class'], $sensorConfig->getClass());
        static::assertEquals($sensorConfigArray['settings'], $sensorConfig->getSettings());
        static::assertTrue($sensorConfig->getCached());
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
     * @covers ::setSettings
     * @covers ::getName
     * @covers ::getEnabled
     * @covers ::getSeverity
     * @covers ::getClass
     * @covers ::getSettings
     */
    public function testDefaultConfig(): void
    {
        $sensorName = 'Dummy Sensor';
        $sensorConfigArray = [
            'class' => DummySensor::class,
        ];
        $sensorConfig = new Config($sensorName, $sensorConfigArray);
        static::assertEquals($sensorName, $sensorConfig->getName());
        static::assertTrue($sensorConfig->getEnabled());
        static::assertEquals(2, $sensorConfig->getSeverity());
        static::assertEquals($sensorConfigArray['class'], $sensorConfig->getClass());
        static::assertEquals([], $sensorConfig->getSettings());
        static::assertFalse($sensorConfig->getCached());
    }

    /**
     * Test Invalid Severity
     *
     * @return void
     * @covers ::setSeverity
     */
    public function testInvalidSeverity(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $sensorName = 'Dummy Sensor';
        $sensorConfigArray = [
            'enabled' => true,
            'severity' => 999999,
            'class' => DummySensor::class,
        ];
        new Config($sensorName, $sensorConfigArray);
    }

    /**
     * Test Invalid Cached
     *
     * @return void
     * @covers ::setEnabled
     */
    public function testInvalidCached(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $sensorName = 'Dummy Sensor';
        $sensorConfigArray = [
            'enabled' => true,
            'severity' => 1,
            'class' => DummySensor::class,
            'cached' => 1,
        ];
        new Config($sensorName, $sensorConfigArray);
    }
}
