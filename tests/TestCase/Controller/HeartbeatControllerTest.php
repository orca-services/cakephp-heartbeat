<?php

namespace OrcaServices\Heartbeat\Test\TestCase\Controller;

use Cake\Chronos\Chronos;
use Cake\Collection\Collection;
use Cake\TestSuite\IntegrationTestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;

class HeartbeatControllerTest extends IntegrationTestCase
{
    /**
     * Tests index
     *
     * @return void
     * @covers ::index
     */
    public function testIndex()
    {
        $this->markTestIncomplete('TODO: Fix this test. Something with routes I guess.');
        Chronos::setTestNow('2017-03-30 12:45:37');
        $this->get('/heartbeat');
        $systemStatus = $this->viewVariable('systemStatus');
        $this->assertInstanceOf(Status::class, $systemStatus);
        $sensorStatuses = $this->viewVariable('sensorStatuses');
        $this->assertInstanceOf(Collection::class, $sensorStatuses);
        $sensorStatuses->each(function ($sensorStatus) {
            $this->assertInstanceOf(Status::class, $sensorStatus);
        });
    }
}
