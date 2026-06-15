<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat\Sensor;

use Cake\TestSuite\TestCase;
use Migrations\Migrations;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Heartbeat\Sensor\DBUpToDate;
use PHPUnit\Framework\MockObject\MockObject;
use RuntimeException;

/**
 * DB Up to Date Sensor Test
 *
 * @coversDefaultClass DBUpToDate
 */
class DBUpToDateTest extends TestCase
{
    /**
     * Builds a sensor with the given Migrations mock.
     *
     * @param Migrations|MockObject $migrations Mocked Migrations
     * @param array<string, mixed> $settings Sensor settings
     * @return DBUpToDate
     */
    private function createSensor($migrations, array $settings = []): DBUpToDate
    {
        $config = new Config('DB up to date', [
            'enabled' => true,
            'severity' => 3,
            'class' => DBUpToDate::class,
            'settings' => $settings,
        ]);

        return new class ($config, $migrations) extends DBUpToDate {
            private Migrations $mockedMigrations;

            public function __construct(Config $config, Migrations $mockedMigrations)
            {
                parent::__construct($config);
                $this->mockedMigrations = $mockedMigrations;
            }

            protected function createMigrations(array $options): Migrations
            {
                return $this->mockedMigrations;
            }
        };
    }

    /**
     * Creates a Migrations mock that returns the given status() result.
     *
     * @param array<int, array<string, mixed>> $statusResult Return value of status()
     * @return Migrations|MockObject
     */
    private function createMigrationsMock(array $statusResult): MockObject
    {
        $migrations = $this->createMock(Migrations::class);
        $migrations->method('status')->willReturn($statusResult);

        return $migrations;
    }

    /**
     * When every migration reports status "up", the sensor reports true.
     *
     * @return void
     * @covers ::_getStatus
     */
    public function testGetStatusReturnsTrueWhenAllMigrationsAreUp(): void
    {
        $migrations = $this->createMigrationsMock([
            ['status' => 'up', 'version' => '20200101000000'],
            ['status' => 'up', 'version' => '20200102000000'],
        ]);

        $sensor = $this->createSensor($migrations);

        $this->assertTrue($sensor->getStatus()->getStatus());
    }

    /**
     * When at least one migration is not "up", the sensor reports false.
     *
     * @return void
     * @covers ::_getStatus
     */
    public function testGetStatusReturnsFalseWhenAMigrationIsPending(): void
    {
        $migrations = $this->createMigrationsMock([
            ['status' => 'up', 'version' => '20200101000000'],
            ['status' => 'down', 'version' => '20200102000000'],
        ]);

        $sensor = $this->createSensor($migrations);

        $this->assertFalse($sensor->getStatus()->getStatus());
    }

    /**
     * An empty migration list (no migrations at all) is treated as up to date.
     *
     * @return void
     * @covers ::_getStatus
     */
    public function testGetStatusReturnsTrueWhenThereAreNoMigrations(): void
    {
        $migrations = $this->createMigrationsMock([]);

        $sensor = $this->createSensor($migrations);

        $this->assertTrue($sensor->getStatus()->getStatus());
    }

    /**
     * If Migrations::status() throws, the sensor catches it and reports false.
     *
     * @return void
     * @covers ::_getStatus
     */
    public function testGetStatusReturnsFalseWhenStatusThrows(): void
    {
        $migrations = $this->createMock(Migrations::class);
        $migrations->method('status')->willThrowException(new RuntimeException());

        $sensor = $this->createSensor($migrations);

        $this->assertFalse($sensor->getStatus()->getStatus());
    }
}
