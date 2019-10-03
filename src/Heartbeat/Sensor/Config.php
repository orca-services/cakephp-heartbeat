<?php

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * Heartbeat Sensor Config
 */
class Config
{

    /**
     * The name of the sensor
     *
     * @var string
     */
    protected $name;

    /**
     * Whether the sensor is enabled
     *
     * @var bool
     */
    protected $enabled;

    /**
     * The severity level
     *
     * @var int
     * @see Status The status constants.
     */
    protected $severity;

    /**
     * The class name
     *
     * @var string|null
     */
    protected $class;

    /**
     * Whether or how long the sensor status should be cached
     *
     * @var bool|string
     */
    protected $cached = false;

    /**
     * Additional settings
     *
     * @var array
     */
    protected $settings = [];

    /**
     * The default config
     *
     * @var array
     */
    protected $defaultConfig = [
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
    public function __construct($name, array $config)
    {
        $this->setName($name);

        $config = array_merge($this->defaultConfig, $config);

        $this->setEnabled($config['enabled']);
        $this->setSeverity($config['severity']);
        $this->setClass($config['class']);
        $this->setCached($config['cached']);
        $this->setSettings($config['settings']);
    }

    /**
     * Get the name of the sensor
     *
     * @return string The name of the sensor.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name of the sensor
     *
     * @param string $name The name of the sensor.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set whether the sensor is enabled
     *
     * @param bool $enabled Whether the sensor is enabled.
     * @return void
     * @throws \InvalidArgumentException If not valid severity level was given.
     */
    protected function setEnabled($enabled)
    {
        if (!is_bool($enabled)) {
            throw new \InvalidArgumentException(sprintf(
                'Enabled must be a boolean, got "%s" instead.', $enabled
            ));
        }

        $this->enabled = $enabled;
    }

    /**
     * Get whether the sensor is enable
     *
     * @return bool Whether the sensor is enable.
     */
    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Set the severity level
     *
     * @param int $severity The severity level.
     * @return void
     * @throws \InvalidArgumentException If not valid severity level was given.
     */
    protected function setSeverity($severity)
    {
        if (!in_array($severity,
            array(Status::STATUS_CRITICAL, Status::STATUS_NONCRITICAL, Status::STATUS_INFORMATIONAL))) {
            throw new \InvalidArgumentException(sprintf(
                'Severity must be a valid severity level, got "%s" instead.', $severity
            ));
        }

        $this->severity = $severity;
    }

    /**
     * Get the severity level
     *
     * @return int The severity level.
     */
    public function getSeverity(): int
    {
        return $this->severity;
    }

    /**
     * Set the class
     *
     * @param string $class The class name.
     * @return void
     */
    protected function setClass($class)
    {
        // TODO Consider checking for valid class name.
        $this->class = $class;
    }

    /**
     * Get the class name
     *
     * @return null|string The class name or null.
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Get whether or how long the status should be cached
     *
     * @return bool|string
     */
    public function getCached()
    {
        return $this->cached;
    }

    /*
     * Set whether or how long the status should be cached
     *
     * @param bool|string $cached Whether or how long the status should be cached.
     * @return void
     * @throws \InvalidArgumentException If not a valid boolean or string was given.
     * @todo Cover the exception.
     */
    public function setCached($cached)
    {
        if (!is_bool($cached) && !is_string($cached)) {
            throw new \InvalidArgumentException(sprintf('Cached must be either a bool or a string, "%s" given instead',
                $cached));
        }

        $this->cached = $cached;
    }

    /**
     * Get additional settings for the sensor
     *
     * @return array The settings of the sensor.
     * @todo Cover by a test.
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * Set the additional settings of the sensor
     *
     * @param array $settings The settings of the sensor.
     * @todo Cover by a test.
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;
    }

}
