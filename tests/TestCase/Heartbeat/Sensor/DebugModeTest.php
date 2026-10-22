<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat\Sensor;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Heartbeat\Sensor\DebugMode;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Severity;

/**
 * Debug Mode Sensor Test
 *
 * @coversDefaultClass \OrcaServices\Heartbeat\Heartbeat\Sensor\DebugMode
 */
class DebugModeTest extends TestCase
{
    /**
     * Builds a configured DebugMode sensor.
     *
     * @return DebugMode
     */
    private function createSensor(): DebugMode
    {
        $config = new Config('Debug-Mode', [
            'enabled' => true,
            'severity' => Severity::INFORMATIONAL,
            'class' => DebugMode::class,
        ]);

        return new DebugMode($config);
    }

    /**
     * When debug mode is enabled, the sensor reports true and the message ENABLED.
     *
     * @return void
     * @covers ::getStatus
     * @covers ::getStatusMessage
     */
    public function testStatusReturnsTrueWhenDebugModeIsEnabled(): void
    {
        Configure::write('debug', true);

        $sensor = $this->createSensor();
        $sensorStatus = $sensor->getSensorStatus();

        $this->assertTrue($sensorStatus->status);
        $this->assertSame('ENABLED', $sensorStatus->message);
    }

    /**
     * When debug mode is disabled, the sensor still reports true and the message DISABLED.
     *
     * @return void
     * @covers ::getStatus
     * @covers ::getStatusMessage
     */
    public function testStatusReturnsTrueWhenDebugModeIsDisabled(): void
    {
        Configure::write('debug', false);

        $sensor = $this->createSensor();
        $sensorStatus = $sensor->getSensorStatus();

        $this->assertTrue($sensorStatus->status);
        $this->assertSame('DISABLED', $sensorStatus->message);
    }
}
