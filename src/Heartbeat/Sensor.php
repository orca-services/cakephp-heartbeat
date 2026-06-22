<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat;

use Cake\Cache\Cache;
use Cake\Chronos\Chronos;
use Cake\Utility\Hash;
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
    public const CACHE_NAME = 'heartbeat';

    /**
     * Default cache duration
     */
    public const CACHE_DEFAULT_DURATION = '+30 seconds';

    /**
     * The sensor config
     */
    protected Config $config;

    /**
     * Construct the status
     *
     * @param Config $config The sensor configuration to set.
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Get the sensor status
     *
     * @return Sensor\Status The sensor status.
     */
    public function getSensorStatus(): Status
    {
        $cachedStatus = $this->getCachedStatus();
        if ($cachedStatus !== false) {
            return $cachedStatus;
        }

        return $this->getNonCachedStatus();
    }

    /**
     * Get the cached status, if available
     *
     * Resets the cache, if disabled.
     *
     * @return Status|bool The cached status or false.
     */
    protected function getCachedStatus(): Status|bool
    {
        $sensorCaching = $this->config->getCached();

        $this->resetCacheConfig($sensorCaching);

        $cacheKey = self::CACHE_NAME . '_' . strtolower(Text::slug($this->config->getName()));
        if ($sensorCaching === false) {
            $cachedStatus = Cache::read($cacheKey, self::CACHE_NAME);
            if (!empty($cachedStatus)) {
                Cache::delete($cacheKey, self::CACHE_NAME);
            }

            return false;
        }

        $cachedStatus = Cache::read($cacheKey, self::CACHE_NAME);
        if (!empty($cachedStatus)) {
            $cachedStatus->setCheckWasCached(true);

            return $cachedStatus;
        }

        $nonCachedStatus = $this->getNonCachedStatus();
        Cache::write($cacheKey, $nonCachedStatus, self::CACHE_NAME);

        return $nonCachedStatus;
    }

    /**
     * Reset the cache configuration
     *
     * @param string|bool $sensorCaching The sensor cache configuration, either a bool or a relative time string.
     * @return void
     */
    protected function resetCacheConfig(string|bool $sensorCaching): void
    {
        Cache::drop(self::CACHE_NAME);

        $duration = self::CACHE_DEFAULT_DURATION;
        if (is_string($sensorCaching)) {
            $duration = $sensorCaching;
        }

        $settings = array_merge(
            (array)Cache::getConfig('default'),
            ['duration' => $duration, 'className' => 'File'],
        );

        Cache::setConfig(self::CACHE_NAME, $settings);
    }

    /**
     * Get the non-cached status
     *
     * @return Status The status object.
     */
    protected function getNonCachedStatus(): Status
    {
        $start = microtime(true);
        $status = $this->getStatus();
        $end = microtime(true);

        $duration = $end - $start;
        $duration = round($duration, 3);

        return new Status(
            $this->config->getName(),
            $status,
            $duration,
            Chronos::now(),
            $this->config->getSeverity(),
            $this->getStatusMessage($status),
        );
    }

    /**
     * Get the status
     *
     * @return bool The sensor status.
     */
    abstract protected function getStatus(): bool;

    /**
     * Get the human-readable status message
     *
     * @param bool $status The sensor status as returned by getStatus().
     * @return string The sensor status message.
     */
    abstract protected function getStatusMessage(bool $status): string;

    /**
     * Get the value of the given setting or an optional fallback default value
     *
     * @param string $name The name of the setting to retrieve.
     * @param mixed|null $default The optional default value, if the setting is not set.
     * @return string|null The value of the setting or the provided default, if not set.
     */
    protected function getSetting(string $name, mixed $default = null): ?string
    {
        $settings = $this->config->getSettings();

        return Hash::get($settings, $name, $default);
    }
}
