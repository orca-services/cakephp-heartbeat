<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Controller;

use Cake\Chronos\Chronos;
use Cake\Collection\Collection;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;
use OrcaServices\Heartbeat\Test\TestApp\TestApplication;

/**
 * HeartbeatController Test
 *
 * @coversDefaultClass \OrcaServices\Heartbeat\Controller\HeartbeatController
 */
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
    public function testIndex(): void
    {
        Chronos::setTestNow('2017-03-30 12:45:37');
        $this->get('/heartbeat');

        $this->assertResponseOk();
        $this->assertHeader('Content-Type', 'text/html; charset=UTF-8');
        $this->assertResponseContains('<title>Heartbeat</title>');

        $systemStatus = $this->viewVariable('systemStatus');
        static::assertInstanceOf(Status::class, $systemStatus);
        $sensorStatuses = $this->viewVariable('sensorStatuses');
        static::assertInstanceOf(Collection::class, $sensorStatuses);
        $sensorStatuses->each(function ($sensorStatus) {
            static::assertInstanceOf(Status::class, $sensorStatus);
        });
    }

    /**
     * Tests index with JSON extension
     *
     * @return void
     * @covers ::index
     */
    public function testIndexJson(): void
    {
        Chronos::setTestNow('2017-03-30 12:45:37');
        $this->get('/heartbeat.json');

        $this->assertResponseOk();
        $this->assertHeader('Content-Type', 'application/json');
        $this->assertResponseContains('"Heartbeat Status":"OK"');
        $responseBody = (string)$this->_response->getBody();
        static::assertJson($responseBody);

        $systemStatus = $this->viewVariable('systemStatus');
        static::assertInstanceOf(Status::class, $systemStatus);
        $sensorStatuses = $this->viewVariable('sensorStatuses');
        static::assertInstanceOf(Collection::class, $sensorStatuses);
        $sensorStatuses->each(function ($sensorStatus) {
            static::assertInstanceOf(Status::class, $sensorStatus);
        });
    }
}
