<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat\Sensor;

use Cake\Database\Connection;
use Cake\Database\Driver\Sqlite;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Heartbeat\Sensor\DBConnection;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Severity;

/**
 * DB Connection Sensor Test
 *
 * @coversDefaultClass DBConnection
 */
class DBConnectionTest extends TestCase
{
    /**
     * Name of the test database connection.
     *
     * @var string
     */
    private const TEST_CONNECTION = 'heartbeat_db_connection_test';

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        if (!extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('The pdo_sqlite extension is required for this test.');
        }

        parent::setUp();

        ConnectionManager::setConfig(self::TEST_CONNECTION, [
            'className' => Connection::class,
            'driver' => Sqlite::class,
            'database' => ':memory:',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function tearDown(): void
    {
        ConnectionManager::drop(self::TEST_CONNECTION);

        parent::tearDown();
    }

    /**
     * Builds a configured DBConnection sensor.
     *
     * @param array $settings Sensor settings
     * @return DBConnection
     */
    private function createSensor(array $settings = []): DBConnection
    {
        $config = new Config('DB Connection', [
            'enabled' => true,
            'severity' => Severity::CRITICAL,
            'class' => DBConnection::class,
            'settings' => $settings,
        ]);

        return new DBConnection($config);
    }

    /**
     * Test _getStatus for the default connection.
     *
     * @return void
     * @covers ::_getStatus
     */
    public function testGetStatusReturnsTrueForDefaultConnection(): void
    {
        $sensor = $this->createSensor();

        $status = $sensor->getSensorStatus();

        $this->assertTrue($status->status);
    }

    /**
     * Test _getStatus for a custom connection.
     *
     * @return void
     * @covers ::_getStatus
     */
    public function testGetStatusReturnsTrueForCustomConnection(): void
    {
        $sensor = $this->createSensor(['connection' => self::TEST_CONNECTION]);

        $status = $sensor->getSensorStatus();

        $this->assertTrue($status->status);
    }

    /**
     * Test _getStatus for an unknown connection.
     *
     * @return void
     * @covers ::_getStatus
     */
    public function testGetStatusReturnsFalseForUnknownConnection(): void
    {
        $sensor = $this->createSensor(['connection' => 'this_connection_does_not_exist']);

        $status = $sensor->getSensorStatus();

        $this->assertFalse($status->status);
    }
}
