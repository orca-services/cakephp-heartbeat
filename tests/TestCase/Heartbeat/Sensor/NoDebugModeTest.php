<?php
declare(strict_types=1);

namespace Heartbeat\Sensor;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Heartbeat\Sensor\NoDebugMode;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Severity;

/**
 * No Debug Mode Sensor Test
 *
 * @coversDefaultClass \OrcaServices\Heartbeat\Heartbeat\Sensor\NoDebugMode
 */
class NoDebugModeTest extends TestCase
{
    /**
     * Builds a configured NoDebugMode sensor.
     *
     * @return NoDebugMode
     */
    private function createSensor(): NoDebugMode
    {
        $config = new Config('No-Debug-Mode', [
            'enabled' => true,
            'severity' => Severity::CRITICAL,
            'class' => NoDebugMode::class,
        ]);

        return new NoDebugMode($config);
    }

    /**
     * When debug mode is enabled, the sensor reports false.
     *
     * @return void
     * @covers ::getStatus
     */
    public function testStatusReturnsFalseWhenDebugModeIsEnabled(): void
    {
        Configure::write('debug', false);

        $sensor = $this->createSensor();
        $sensorStatus = $sensor->getSensorStatus();

        $this->assertTrue($sensorStatus->status);
    }

    /**
     * When debug mode is disabled, the sensor reports true.
     *
     * @return void
     * @covers ::getStatus
     */
    public function testStatusReturnsTrueWhenDebugModeIsDisabled(): void
    {
        Configure::write('debug', true);

        $sensor = $this->createSensor();
        $sensorStatus = $sensor->getSensorStatus();

        $this->assertFalse($sensorStatus->status);
    }
}
