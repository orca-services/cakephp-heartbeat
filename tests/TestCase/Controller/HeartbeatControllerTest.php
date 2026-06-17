<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Controller;

use Cake\Chronos\Chronos;
use Cake\Collection\Collection;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;
use OrcaServices\Heartbeat\Test\TestApp\TestApplication;

class HeartbeatControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->_appClass = TestApplication::class;
    }

    /**
     * Tests index
     *
     * @return void
     * @covers ::index
     */
    public function testIndex()
    {
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
