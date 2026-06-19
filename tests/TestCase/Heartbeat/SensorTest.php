<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat;

use Cake\Chronos\Chronos;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Severity;
use OrcaServices\Heartbeat\Test\TestCase\Sensor\DummySensor;
use ReflectionClass;

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
     * @throws ReflectionException
     */
    public function testConstructor()
    {
        $sensorName = 'Dummy Sensor';
        $sensorConfig = [
            'enabled' => true,
            'severity' => Severity::INFORMATIONAL,
            'class' => DummySensor::class,
        ];
        $sensorConfig = new Config($sensorName, $sensorConfig);
        $sensorClassName = $sensorConfig->getClass();
        /** @var Sensor $sensor */
        $sensor = new $sensorClassName($sensorConfig);
        $this->assertEquals($sensorConfig, $this->getProperty($sensor, 'config'));
    }

    /**
     * Tests the constructor
     *
     * @return void
     * @covers ::getSensorStatus
     * @covers ::_getStatus
     */
    public function testGetStatus()
    {
        Chronos::setTestNow('2017-03-30 12:45:37');
        $sensorName = 'Dummy Sensor';
        $sensorConfig = [
            'enabled' => true,
            'severity' => Severity::INFORMATIONAL,
            'class' => DummySensor::class,
        ];
        $sensorConfig = new Config($sensorName, $sensorConfig);
        $sensorClassName = $sensorConfig->getClass();
        /** @var Sensor $sensor */
        $sensor = new $sensorClassName($sensorConfig);
        $status = $sensor->getStatus();
        $this->assertEquals('Dummy Sensor', $status->name);
        $this->assertTrue($status->status);
        $this->assertEquals(0, $status->duration);
        $this->assertEquals('2017-03-30 12:45:37', $status->lastExecuted);
        $this->assertEquals(Severity::INFORMATIONAL, $status->severity);
    }

    /**
     * Tests whether the check result was fetched from cache or by running the check now
     *
     * @return void
     * @covers ::_getCachedStatus
     * @covers ::_resetCacheConfig
     * @covers ::_getNonCachedStatus
     */
    public function testWasCheckCached()
    {
        Chronos::setTestNow('2017-03-30 12:45:37');
        $sensorName = 'Cached Sensor';
        $sensorConfig = [
            'enabled' => true,
            'severity' => Severity::INFORMATIONAL,
            'class' => DummySensor::class,
            'cached' => '+1 seconds',
        ];
        $sensorConfig = new Config($sensorName, $sensorConfig);
        $sensorClassName = $sensorConfig->getClass();

        /** @var DummySensor $sensor */
        $sensor = new $sensorClassName($sensorConfig);
        $status = $sensor->getSensorStatus();

        // Assert that result was not cached
        $this->assertFalse($status->wasCheckCached());

        // Get status again and assert that result was cached
        $status = $sensor->getSensorStatus();
        $this->assertTrue($status->wasCheckCached());

        // Get status again after slightly more than a second and assert that result was not cached
        sleep(2);
        $status = $sensor->getSensorStatus();
        $this->assertFalse($status->wasCheckCached());

        //// Wait another second to let the cache be reset
        sleep(1);
    }

    /**
     * Tests whether the check result was fetched from cache when cache is disabled
     *
     * @return void
     * @covers ::_getCachedStatus
     * @covers ::_resetCacheConfig
     * @covers ::_getNonCachedStatus
     */
    public function testWasCheckCachedWhenCacheDisabled()
    {
        Chronos::setTestNow('2017-03-30 12:45:37');
        $sensorName = 'Uncached Sensor';
        $sensorConfig = [
            'enabled' => true,
            'severity' => Severity::INFORMATIONAL,
            'class' => DummySensor::class,
            'cached' => false,
        ];
        $sensorConfig = new Config($sensorName, $sensorConfig);
        $sensorClassName = $sensorConfig->getClass();

        /** @var DummySensor $sensor */
        $sensor = new $sensorClassName($sensorConfig);
        $status = $sensor->getSensorStatus();

        $this->assertFalse($status->wasCheckCached());
        $status = $sensor->getSensorStatus();
        $this->assertFalse($status->wasCheckCached());
    }

    /**
     * Returns value of private and protected properties.
     *
     * @param mixed $object The object
     * @param string $property The property name
     * @return mixed The value
     * @throws ReflectionException
     */
    public static function getProperty(mixed $object, string $property): mixed
    {
        $reflectedClass = new ReflectionClass($object);
        $reflection = $reflectedClass->getProperty($property);

        return $reflection->getValue($object);
    }
}
