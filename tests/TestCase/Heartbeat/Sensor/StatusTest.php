<?php

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat\Sensor;

use Cake\Chronos\Chronos;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;
use PHPUnit\Framework\TestCase;

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
     * @covers ::getName
     * @covers ::getStatus
     * @covers ::getDuration
     * @covers ::getLastExecuted
     * @covers ::getSeverity
     * @covers ::wasCheckCached
     */
    public function testStatus()
    {
        Chronos::setTestNow('2017-03-30 12:45:37');
        $status = new Status('Dummy Sensor', true, 0, Chronos::now(), 1);
        $this->assertInstanceOf(Status::class, $status);
        $this->assertEquals('Dummy Sensor', $status->getName());
        $this->assertEquals(true, $status->getStatus());
        $this->assertEquals(0, $status->getDuration());
        $this->assertEquals('2017-03-30 12:45:37', $status->getLastExecuted());
        $this->assertEquals(1, $status->getSeverity());
        $this->assertEquals(false, $status->wasCheckCached());
    }

    /**
     * Tests setting & getting whether the check was cached
     *
     * @return void
     * @covers ::setCheckWasCached
     * @covers ::wasCheckCached
     */
    public function testSetGetCheckWasCached()
    {
        $status = new Status('Dummy Sensor', true, 0, Chronos::now(), 1);
        $this->assertFalse($status->wasCheckCached());
        $status->setCheckWasCached(true);
        $this->assertTrue($status->wasCheckCached());
        $status->setCheckWasCached(false);
        $this->assertFalse($status->wasCheckCached());

    }
}
