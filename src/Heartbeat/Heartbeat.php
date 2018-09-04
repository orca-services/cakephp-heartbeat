<?php

namespace OrcaServices\Heartbeat\Heartbeat;

use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;

/**
 * The Heartbeat
 *
 * Executes the configured sensor checks and returns their status.
 */
class Heartbeat {

	/**
	 * Whether the Heartbeat sensor statuses should be cached by default. Can be overridden. Defaults to true.
	 *
	 * @var bool
	 */
	protected $cached = true;

	/**
	 * The sensor statuses
	 *
	 * @var array
	 */
	protected $sensorStatuses = [];

	/**
	 * Executes the sensor checks an populates their statuses.
	 *
	 * @return $this
	 */
	public function check() {
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
	protected function _getEnabledSensors() {
		$sensors = (array)Configure::read('App.Heartbeat.Sensors');
		$collection = collection($sensors);
		$sensors = $collection->filter(function ($sensor) {
			return $sensor['enabled'] === true;
		});
		return $sensors;
	}

	/**
	 * Get the sensor through its configuration
	 *
	 * @param string $sensorName The name of the sensor.
	 * @param array $sensorConfig The sensor configuration.
	 * @return Sensor The configures sensor.
	 */
	protected function _getSensor($sensorName, $sensorConfig) {
		$sensorConfig = new Sensor\Config($sensorName, $sensorConfig);
		if (!$this->cached) {
			$sensorConfig->setCached(false);
		}
		$sensorClassName = $sensorConfig->getClass();
		/** @var Sensor $sensor */
		$sensor = new $sensorClassName($sensorConfig);

		return $sensor;
	}

	/**
	 * Get the sensor statuses
	 *
	 * @return Status[]|\Cake\Collection\Collection The sensor statuses.
	 */
	public function getSensorStatuses() {
		return collection($this->sensorStatuses);
	}

	/**
	 * Get the system status
	 *
	 * @return Status The system status.
	 */
	public function getSystemStatus() {
		$sensorStatuses = $this->getSensorStatuses();

		$systemStatus = !$sensorStatuses->some(function ($sensorStatus) {
			/** @var \OrcaServices\Heartbeat\Heartbeat\Sensor\Status $sensorStatus */
			if ($sensorStatus->getSeverity() === Status::STATUS_CRITICAL) {
				return $sensorStatus->getStatus() === false;
			}

			return false;
		});

		$name = Configure::read('App.Heartbeat.name');

		$status = new Status(
			$name . ' Heartbeat Status',
			$systemStatus,
			0, // TODO Calculate the duration for the whole heartbeat
			Chronos::now(),
			Status::STATUS_CRITICAL
		);

		return $status;
	}

	/**
	 * Set whether the Heartbeat sensor statuses should be cached by default
	 *
	 * @param bool $cached True if yes, else false.
	 * @throws \InvalidArgumentException If not a valid boolean was given.
	 * @todo Cover set & exception.
	 */
	public function setCached($cached) {
		if (!is_bool($cached)) {
			throw new \InvalidArgumentException(sprintf('Cached must be a bool, "%s" given instead', $cached));
		}

		$this->cached = $cached;
	}



}
