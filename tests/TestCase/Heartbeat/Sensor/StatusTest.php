<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat\Sensor;

use Cake\Chronos\Chronos;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Severity;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;

/**
 * Status Tests
 *
 * @coversDefaultClass \OrcaServices\Heartbeat\Heartbeat\Sensor\Status
 */
class StatusTest extends TestCase
{
    /**
     * Tests Status class
     *
     * @return void
     * @covers ::__construct
     */
    public function testStatus(): void
    {
        Chronos::setTestNow('2017-03-30 12:45:37');

        $name = 'Dummy Sensor';
        $statusBool = true;
        $duration = 0;
        $lastExecuted = Chronos::now();
        $severity = Severity::INFORMATIONAL;
        $message = __d('Heartbeat', 'OK');

        $status = new Status(
            $name,
            $statusBool,
            $duration,
            $lastExecuted,
            $severity,
            $message,
        );

        $this->assertEquals($name, $status->name);
        $this->assertEquals($statusBool, $status->status);
        $this->assertEquals($duration, $status->duration);
        $this->assertEquals($lastExecuted->toDateTimeString(), $status->lastExecuted);
        $this->assertEquals($severity, $status->severity);
        $this->assertEquals($message, $status->message);
        $this->assertFalse($status->wasCached);
    }

    /**
     * Tests that the cached flag can be set through the constructor
     *
     * @return void
     * @covers ::__construct
     */
    public function testWasCached(): void
    {
        $status = new Status(
            'Dummy Sensor',
            true,
            0,
            Chronos::now(),
            Severity::INFORMATIONAL,
            __d('Heartbeat', 'OK'),
            true,
        );

        $this->assertTrue($status->wasCached);
    }
}
