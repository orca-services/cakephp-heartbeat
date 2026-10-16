<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Core\Configure;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * Debug Mode by Environment Sensor
 */
class DebugModeByEnvironment extends Sensor
{
    /**
     * @inheritDoc
     */
    protected array $defaultSettings = [
        // The current environment. Null means `App.Heartbeat.environment` is used.
        'environment' => null,
        // Map of environment names (case-insensitive) to the expected debug mode.
        'environments' => [
            'dev' => true,
            'development' => true,
            'test' => false,
            'testing' => false,
            'staging' => false,
            'prod' => false,
            'production' => false,
        ],
    ];

    /**
     * @inheritDoc
     */
    protected function getStatus(): bool
    {
        return $this->isDebugModeEnabled() === $this->getExpectedDebugMode();
    }

    /**
     * @inheritDoc
     */
    protected function getStatusMessage(bool $status): string
    {
        return $this->isDebugModeEnabled() ? __d('Heartbeat', 'ENABLED') : __d('Heartbeat', 'DISABLED');
    }

    /**
     * Whether the debug mode is currently enabled
     *
     * @return bool True if enabled, false otherwise.
     */
    protected function isDebugModeEnabled(): bool
    {
        return (bool)Configure::read('debug');
    }

    /**
     * Get the current environment
     *
     * @return string|null The name of the current environment or null if unknown.
     */
    protected function getEnvironment(): ?string
    {
        $environment = $this->getSetting('environment') ?? Configure::read('App.Heartbeat.environment');

        if (!is_string($environment) || trim($environment) === '') {
            return null;
        }

        return trim($environment);
    }

    /**
     * Get the expected debug mode for the current environment
     *
     * An unknown environment expects the debug mode to be disabled, to fail-safe.
     *
     * @return bool True if it must be enabled, false if it must be disabled.
     */
    protected function getExpectedDebugMode(): bool
    {
        $environment = $this->getEnvironment();

        if ($environment === null) {
            return false;
        }

        return $this->getEnvironmentExpectations()[strtolower($environment)] ?? false;
    }

    /**
     * Get the expected debug modes, keyed by the normalized environment names
     *
     * Entries without a boolean expectation are ignored.
     *
     * @return array<string, bool> The expected debug modes.
     */
    protected function getEnvironmentExpectations(): array
    {
        $expectations = [];
        foreach ((array)$this->getSetting('environments', []) as $environment => $expectedDebugMode) {
            $environment = trim((string)$environment);
            if ($environment === '' || !is_bool($expectedDebugMode)) {
                continue;
            }
            $expectations[strtolower($environment)] = $expectedDebugMode;
        }

        return $expectations;
    }
}
