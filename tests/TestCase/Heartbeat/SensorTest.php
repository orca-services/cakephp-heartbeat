<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat;

use Cake\Chronos\Chronos;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor;
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
     */
    public function testConstructor(): void
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
        $this->assertEquals($sensorConfig, self::getProperty($sensor, 'config'));
    }

    /**
     * Tests the constructor
     *
     * @return void
     * @covers ::getSensorStatus
     * @covers ::getStatus
     */
    public function testGetStatus(): void
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
        $sensorStatus = $sensor->getSensorStatus();
        $this->assertEquals('Dummy Sensor', $sensorStatus->name);
        $this->assertTrue($sensorStatus->status);
        $this->assertEquals(0, $sensorStatus->duration);
        $this->assertEquals('2017-03-30 12:45:37', $sensorStatus->lastExecuted);
        $this->assertEquals(Severity::INFORMATIONAL, $sensorStatus->severity);
    }

    /**
     * Tests whether the check result was fetched from cache or by running the check now
     *
     * @return void
     * @covers ::getCachedStatus
     * @covers ::resetCacheConfig
     * @covers ::getNonCachedStatus
     */
    public function testWasCached(): void
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
        $sensorStatus = $sensor->getSensorStatus();

        // Assert that result was not cached
        $this->assertFalse($sensorStatus->wasCached);

        // Get status again and assert that result was cached
        $sensorStatus = $sensor->getSensorStatus();
        $this->assertTrue($sensorStatus->wasCached);

        // Get status again after slightly more than a second and assert that result was not cached
        sleep(2);
        $sensorStatus = $sensor->getSensorStatus();
        $this->assertFalse($sensorStatus->wasCached);

        //// Wait another second to let the cache be reset
        sleep(1);
    }

    /**
     * Tests whether the check result was fetched from cache when cache is disabled
     *
     * @return void
     * @covers ::getCachedStatus
     * @covers ::resetCacheConfig
     * @covers ::getNonCachedStatus
     */
    public function testWasCachedWhenCacheDisabled(): void
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
        $sensorStatus = $sensor->getSensorStatus();

        $this->assertFalse($sensorStatus->wasCached);
        $sensorStatus = $sensor->getSensorStatus();
        $this->assertFalse($sensorStatus->wasCached);
    }

    /**
     * Returns value of private and protected properties.
     *
     * @param mixed $object The object
     * @param string $property The property name
     * @return mixed The value
     */
    public static function getProperty(mixed $object, string $property): mixed
    {
        $reflectedClass = new ReflectionClass($object);
        $reflection = $reflectedClass->getProperty($property);

        return $reflection->getValue($object);
    }

    /**
     * Configured settings are merged on top of the sensor's default settings.
     *
     * @return void
     * @covers ::getSetting
     */
    public function testGetSettingMergesConfiguredSettingsOverDefaultSettings(): void
    {
        $connectionName = 'custom';
        $config = new Config('Settings Sensor', [
            'enabled' => true,
            'severity' => Severity::INFORMATIONAL,
            'class' => DummySensor::class,
            'settings' => ['connection' => $connectionName],
        ]);

        $sensor = new class ($config) extends Sensor {
            protected array $defaultSettings = [
                'connection' => 'default',
                'source' => 'Migrations',
            ];

            protected function getStatus(): bool
            {
                return true;
            }

            public function readSetting(string $name): ?string
            {
                return $this->getSetting($name);
            }
        };

        // A configured value wins over the default setting.
        $this->assertSame($connectionName, $sensor->readSetting('connection'));
        // The default setting is used when the setting is not configured.
        $this->assertSame('Migrations', $sensor->readSetting('source'));
        // Neither configured nor declared as a default setting -> null.
        $this->assertNull($sensor->readSetting('unknown'));
    }
}
