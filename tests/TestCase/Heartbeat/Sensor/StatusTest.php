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
     * @covers ::wasCheckCached
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
        $this->assertEquals(false, $status->wasCheckCached());
        $this->assertFalse($status->wasCached);
    }

    /**
     * Tests that the cached flag can be set through the constructor
     *
     * @return void
     * @covers ::__construct
     * @covers ::wasCheckCached
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
        $this->assertTrue($status->wasCheckCached());
    }

    /**
     * Tests setting & getting whether the check was cached
     *
     * @return void
     * @covers ::setCheckWasCached
     * @covers ::wasCheckCached
     */
    public function testSetGetCheckWasCached(): void
    {
        $status = new Status(
            'Dummy Sensor',
            true,
            0,
            Chronos::now(),
            Severity::INFORMATIONAL,
            __d('Heartbeat', 'OK'),
        );

        $this->assertFalse($status->wasCheckCached());
        $status->setCheckWasCached(true);
        $this->assertTrue($status->wasCheckCached());
        $status->setCheckWasCached(false);
        $this->assertFalse($status->wasCheckCached());
    }
}
