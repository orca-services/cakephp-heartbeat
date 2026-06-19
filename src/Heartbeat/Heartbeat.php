<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat;

use Cake\Chronos\Chronos;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Severity;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;

/**
 * The Heartbeat
 *
 * Executes the configured sensor checks and returns their status.
 */
class Heartbeat
{
    /**
     * Whether the Heartbeat sensor statuses should be cached by default. Can be overridden. Defaults to true.
     */
    protected bool $cached = true;

    /**
     * The sensor statuses
     */
    protected array $sensorStatuses = [];

    /**
     * Executes the sensor checks and populates their statuses.
     *
     * @return $this
     */
    public function check()
    {
        $sensors = $this->_getEnabledSensors();

        $this->sensorStatuses = [];
        foreach ($sensors as $sensorName => $sensorConfig) {
            $sensor = $this->_getSensor($sensorName, $sensorConfig);
            $this->sensorStatuses[] = $sensor->getStatus();
        }

        return $this;
    }

    /**
     * Get all enabled sensors from the config
     *
     * @return array All enabled sensors.
     */
    protected function _getEnabledSensors(): array
    {
        $sensors = (array)Configure::read('App.Heartbeat.Sensors');
        $collection = collection($sensors);
        $sensors = $collection->filter(function ($sensor) {
            return $sensor['enabled'] === true;
        });

        return $sensors->toArray();
    }

    /**
     * Get the sensor through its configuration
     *
     * @param string $sensorName The name of the sensor.
     * @param array $sensorConfig The sensor configuration.
     * @return Sensor The configures sensor.
     */
    protected function _getSensor(string $sensorName, array $sensorConfig): Sensor
    {
        $config = new Sensor\Config($sensorName, $sensorConfig);
        if (!$this->cached) {
            $config->setCached(false);
        }
        $sensorClassName = $config->getClass();
        /** @var Sensor $sensor */
        $sensor = new $sensorClassName($config);

        return $sensor;
    }

    /**
     * Get the sensor statuses
     *
     * @return Collection The sensor statuses.
     */
    public function getSensorStatuses(): Collection
    {
        return collection($this->sensorStatuses);
    }

    /**
     * Get the system status
     *
     * @return Status The system status.
     */
    public function getSystemStatus(): Status
    {
        $sensorStatuses = $this->getSensorStatuses();

        $systemStatus = !$sensorStatuses->some(function ($sensorStatus) {
            /** @var Status $sensorStatus */
            if ($sensorStatus->severity === Severity::CRITICAL) {
                return $sensorStatus->status === false;
            }

            return false;
        });

        $name = Configure::read('App.Heartbeat.name');

        return new Status(
            $name . ' Heartbeat Status',
            $systemStatus,
            0, // TODO Calculate the duration for the whole heartbeat
            Chronos::now(),
            Severity::CRITICAL,
        );
    }

    /**
     * Set whether the Heartbeat sensor statuses should be cached by default
     *
     * @param bool $cached True if yes, else false.
     * @return void
     * @throws \InvalidArgumentException If not a valid boolean was given.
     * @todo Cover set & exception.
     */
    public function setCached(bool $cached): void
    {
        $this->cached = $cached;
    }
}
