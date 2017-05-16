<?php

namespace OrcaServices\Heartbeat;

use Cake\Chronos\Chronos;
use OrcaServices\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Sensor\Status;

/**
 * A Heartbeat Sensor
 *
 * Can execute a sensor and return a sensor status.
 */
abstract class Sensor {

	/**
	 * The sensor config
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * Construct the status
	 *
	 * @param Config $config
	 */
	public function __construct(Config $config) {
		$this->config = $config;
	}

	/**
	 * Get the status
	 *
	 * @return Sensor\Status The sensor status.
	 */
	public function getStatus() {
		$cachedStatus = $this->_getCachedStatus();
		if ($cachedStatus !== false) {
			return $cachedStatus;
		}

		$status = $this->_getNonCachedStatus();

		return $status;
	}

	/**
	 * Get the cached status, if available
	 *
	 * Resets the cache, if disabled.
	 *
	 * @return bool|Status The cached status or false.
	 */
	protected function _getCachedStatus() {
		$cacheKey = 'heartbeat_' . strtolower(\Inflector::slug($this->config->getName()));
		$cached = $this->config->getCached();

		$duration = '+30 seconds';
		if (is_string($cached)) {
			$duration = $cached;
		}

		$settings = array_merge(
			\Cache::settings(),
			array('duration' => $duration)
		);

		\Cache::config('heartbeat', $settings);

		if ($cached === false) {
			\Cache::delete($cacheKey, 'heartbeat');
			return false;
		}

		$cachedStatus = \Cache::remember($cacheKey, function () {
			return $this->_getNonCachedStatus();
		}, 'heartbeat');

		return $cachedStatus;
}

	/**
	 * Get the non-cached status
	 *
	 * @return Status The status object.
	 */
	protected function _getNonCachedStatus() {
		$start = microtime(true);
		$status = $this->_getStatus();
		$end = microtime(true);

		$duration = $end - $start;
		$duration = round($duration, 3);

		$status = new Status(
			$this->config->getName(),
			$status,
			$duration,
			Chronos::now(),
			$this->config->getSeverity()
		);

		return $status;
	}

	/**
	 * Get the status
	 *
	 * @return mixed The sensor status.
	 */
	protected abstract function _getStatus();

}
