<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat\Sensor;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Heartbeat\Sensor\DebugMode;

/**
 * Debug Mode Sensor Test
 *
 * @coversDefaultClass DebugMode
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
            'severity' => 1,
            'class' => DebugMode::class,
        ]);

        return new DebugMode($config);
    }

    /**
     * When debug mode is enabled, the sensor reports true.
     *
     * @return void
     * @covers ::_getStatus
     */
    public function testGetStatusReturnsOneWhenDebugIsEnabled(): void
    {
        Configure::write('debug', true);

        $sensor = $this->createSensor();

        $status = $sensor->getStatus();

        $this->assertTrue($status->getStatus());
    }

    /**
     * When debug mode is disabled, the sensor reports false.
     *
     * @return void
     * @covers ::_getStatus
     */
    public function testGetStatusReturnsEmptyStringWhenDebugIsDisabled(): void
    {
        Configure::write('debug', false);

        $sensor = $this->createSensor();

        $status = $sensor->getStatus();

        $this->assertFalse($status->getStatus());
    }
}
