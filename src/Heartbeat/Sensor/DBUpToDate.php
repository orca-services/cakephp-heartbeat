<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Exception;
use Migrations\Migrations;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * DB Up to Date Sensor
 *
 * This sensor depends on the CakePHP Migrations plugin.
 * Make sure the plugin is loaded before calling this sensor.
 *
 * @link https://github.com/cakephp/migrations/
 */
class DBUpToDate extends Sensor
{
    /**
     * Migration status indicating the migration was executed successfully.
     */
    public const MIGRATION_STATUS_UP = 'up';

    /**
     * @inheritDoc
     */
    protected array $defaultSettings = [
        'connection' => 'default',
        'source' => 'Migrations',
        'plugin' => null,
    ];

    /**
     * @inheritDoc
     */
    protected function getStatus(): bool
    {
        try {
            $migrations = $this->createMigrations($this->buildMigrationsOptions());

            foreach ($migrations->status() as $migration) {
                if ($migration['status'] !== self::MIGRATION_STATUS_UP) {
                    return false;
                }
            }
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function getStatusMessage(bool $status): string
    {
        return $status ? __d('Heartbeat', 'OK') : __d('Heartbeat', 'FAILED');
    }

    /**
     * Creates the Migrations instance used to check the status.
     *
     * @param array<string, mixed> $options Options as built by buildMigrationsOptions()
     * @return Migrations
     */
    protected function createMigrations(array $options): Migrations
    {
        return new Migrations($options);
    }

    /**
     * Build the options array passed to the Migrations plugin.
     *
     * @return array<string, mixed>
     */
    private function buildMigrationsOptions(): array
    {
        $options = [
            'connection' => $this->getSetting('connection'),
            'source' => $this->getSetting('source'),
        ];

        $pluginName = $this->getSetting('plugin');
        if ($pluginName !== null) {
            $options['plugin'] = $pluginName;
        }

        return $options;
    }
}
