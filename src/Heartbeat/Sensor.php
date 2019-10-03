<?php

namespace OrcaServices\Heartbeat\Heartbeat;

use Cake\Cache\Cache;
use Cake\Chronos\Chronos;
use Cake\Utility\Text;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;

/**
 * A Heartbeat Sensor
 *
 * Can execute a sensor and return a sensor status.
 */
abstract class Sensor
{
    /**
     * Cache name used throughout the plugin
     */
    const CACHE_NAME = 'heartbeat';

    /**
     * Default cache duration
     */
    const CACHE_DEFAULT_DURATION = '+30 seconds';

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
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Get the status
     *
     * @return Sensor\Status The sensor status.
     */
    public function getStatus(): Status
    {
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
    protected function _getCachedStatus()
    {
        $sensorCaching = $this->config->getCached();

        $this->_resetCacheConfig($sensorCaching);

        $cacheKey =  self::CACHE_NAME . '_' . strtolower(Text::slug($this->config->getName()));
        if ($sensorCaching === false) {
            $cachedStatus = Cache::read($cacheKey, self::CACHE_NAME);
            if (!empty($cachedStatus)) {
                Cache::delete($cacheKey, self::CACHE_NAME);
            }

            return false;
        }

        $cachedStatus = Cache::read($cacheKey, self::CACHE_NAME);
        if($cachedStatus !== false) {
            $cachedStatus->setCheckWasCached(true);

            return $cachedStatus;
        }

        $nonCachedStatus = $this->_getNonCachedStatus();
        Cache::write($cacheKey, $nonCachedStatus, self::CACHE_NAME);

        return $nonCachedStatus;
    }

    /**
     * Reset the cache configuration
     *
     * @param bool|string $sensorCaching The sensor cache configuration, either a bool or a relative time string.
     * @return void
     */
    protected function _resetCacheConfig($sensorCaching)
    {
        Cache::drop(self::CACHE_NAME);

        $duration = self::CACHE_DEFAULT_DURATION;
        if (is_string($sensorCaching)) {
            $duration = $sensorCaching;
        }

        $settings = array_merge(
            (array)Cache::getConfig('default'),
            ['duration' => $duration, 'className' => 'File']
        );

        Cache::setConfig(self::CACHE_NAME, $settings);
    }

    /**
     * Get the non-cached status
     *
     * @return Status The status object.
     */
    protected function _getNonCachedStatus(): Status
    {
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
    abstract protected function _getStatus();
}
