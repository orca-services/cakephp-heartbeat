<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Core\InstanceConfigTrait;
use InvalidArgumentException;

/**
 * Heartbeat Sensor Config
 */
class Config
{
    use InstanceConfigTrait;

    /** @var array All valid severity levels */
    public const SEVERITY_LEVELS = [
        Status::STATUS_CRITICAL,
        Status::STATUS_NONCRITICAL,
        Status::STATUS_INFORMATIONAL,
    ];

    /**
     * The default config
     */
    protected array $_defaultConfig = [
        'name' => null,
        'enabled' => true,
        'severity' => Status::STATUS_NONCRITICAL,
        'class' => null,
        'cached' => false,
        'settings' => [],
    ];

    /**
     * Config constructor.
     *
     * @param string $name The name of the sensor.
     * @param array $config The config to use.
     */
    public function __construct(string $name, array $config)
    {
        // Merge with defaults, overwrite (no recursive merge) to match original behavior.
        $this->setConfig(['name' => $name] + $config, null, false);

        // Validate the values that have constraints.
        $this->assertSeverity($this->getConfig('severity'));
        $this->assertCached($this->getConfig('cached'));
    }

    /**
     * Get the name of the sensor
     *
     * @return string The name of the sensor.
     */
    public function getName(): string
    {
        return $this->getConfig('name');
    }

    /**
     * Set the name of the sensor
     *
     * @param string $name The name of the sensor.
     * @return void
     */
    public function setName(string $name): void
    {
        $this->setConfig('name', $name, false);
    }

    /**
     * Set whether the sensor is enabled
     *
     * @param bool $enabled Whether the sensor is enabled.
     * @return void
     */
    public function setEnabled(bool $enabled): void
    {
        $this->setConfig('enabled', $enabled, false);
    }

    /**
     * Get whether the sensor is enabled
     *
     * @return bool Whether the sensor is enabled.
     */
    public function getEnabled(): bool
    {
        return (bool)$this->getConfig('enabled');
    }

    /**
     * Set the severity level
     *
     * @param int $severity The severity level.
     * @return void
     * @throws InvalidArgumentException If an invalid severity level was given.
     */
    public function setSeverity(int $severity): void
    {
        $this->assertSeverity($severity);
        $this->setConfig('severity', $severity, false);
    }

    /**
     * Get the severity level
     *
     * @return int The severity level.
     */
    public function getSeverity(): int
    {
        return (int)$this->getConfig('severity');
    }

    /**
     * Set the class
     *
     * @param string $class The class name.
     * @return void
     */
    public function setClass(string $class): void
    {
        // TODO Consider checking for valid class name.
        $this->setConfig('class', $class, false);
    }

    /**
     * Get the class name
     *
     * @return string|null The class name or null.
     */
    public function getClass(): ?string
    {
        return $this->getConfig('class');
    }

    /**
     * Get whether or how long the status should be cached
     *
     * @return bool|string
     */
    public function getCached()
    {
        return $this->getConfig('cached');
    }

    /**
     * Set whether or how long the status should be cached
     *
     * @param bool|string $cached Whether or how long the status should be cached.
     * @return void
     * @throws InvalidArgumentException If not a valid boolean or string was given.
     * @todo Cover the exception.
     */
    public function setCached($cached): void
    {
        $this->assertCached($cached);
        $this->setConfig('cached', $cached, false);
    }

    /**
     * Get additional settings for the sensor
     *
     * @return array The settings of the sensor.
     */
    public function getSettings(): array
    {
        return (array)$this->getConfig('settings');
    }

    /**
     * Set the additional settings of the sensor
     *
     * @param array $settings The settings of the sensor.
     * @return void
     */
    public function setSettings(array $settings): void
    {
        $this->setConfig('settings', $settings, false);
    }

    /**
     * Assert that the given severity level is valid.
     *
     * @param mixed $severity The severity level to check.
     * @return void
     * @throws InvalidArgumentException If an invalid severity level was given.
     */
    private function assertSeverity($severity): void
    {
        if (!in_array($severity, self::SEVERITY_LEVELS, true)) {
            throw new InvalidArgumentException(sprintf(
                'Severity must be a valid severity level, got "%s" instead.',
                $severity
            ));
        }
    }

    /**
     * Assert that the given cached value is valid.
     *
     * @param mixed $cached The cached value to check.
     * @return void
     * @throws InvalidArgumentException If an invalid boolean or string was given.
     */
    private function assertCached($cached): void
    {
        if (!is_bool($cached) && !is_string($cached)) {
            throw new InvalidArgumentException(sprintf(
                'Cached must be either a bool or a string, "%s" given instead',
                $cached
            ));
        }
    }
}
