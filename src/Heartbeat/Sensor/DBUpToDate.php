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
     * The default connection name. Defaults to `default`.
     */
    protected string $defaultConnectionName = 'default';

    /**
     * The default migrations source (subfolder of config). Defaults to `Migrations`.
     */
    protected string $defaultSource = 'Migrations';

    /**
     * @inheritDoc
     */
    protected function _getStatus(): bool
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
            'connection' => $this->getSetting('connection', $this->defaultConnectionName),
            'source' => $this->getSetting('source', $this->defaultSource),
        ];

        $pluginName = $this->getSetting('plugin');
        if ($pluginName !== null) {
            $options['plugin'] = $pluginName;
        }

        return $options;
    }
}
