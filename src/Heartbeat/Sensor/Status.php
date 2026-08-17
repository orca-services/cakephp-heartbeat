<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Chronos\Chronos;

/**
 * Heartbeat Status
 */
class Status
{
    /**
     * @var string The name of the sensor
     */
    public readonly string $name;

    /**
     * @var bool The actual status
     */
    public readonly bool $status;

    /**
     * @var string The human-readable status message
     */
    public readonly string $message;

    /**
     * @var float The sensor check duration in seconds
     */
    public readonly float $duration;

    /**
     * @var Chronos The date/time when the sensor check was last executed
     */
    public readonly Chronos $lastExecuted;

    /**
     * @var Severity How severe the status is, e.g. critical
     */
    public readonly Severity $severity;

    /**
     * @var bool Whether the sensor status was fetched from cache
     * @deprecated Backing field for the deprecated cache accessors. Use the readonly $wasCached property instead.
     */
    protected bool $checkCached;

    /**
     * @var bool Whether the sensor status was fetched from cache
     */
    public readonly bool $wasCached;

    /**
     * Status construction
     *
     * @param string $name The name of the sensor
     * @param bool $status The actual status.
     * @param float $duration How long it took to execute the check.
     * @param Chronos $lastExecuted The date/time when it was executed last.
     * @param Severity $severity The status severity.
     * @param string $message The human-readable status message.
     * @param bool $wasCached Whether the status was fetched from cache.
     */
    public function __construct(
        string $name,
        bool $status,
        float $duration,
        Chronos $lastExecuted,
        Severity $severity,
        string $message,
        bool $wasCached = false,
    ) {
        $this->severity = $severity;
        $this->lastExecuted = $lastExecuted;
        $this->duration = $duration;
        $this->status = $status;
        $this->name = $name;
        $this->message = $message;
        $this->wasCached = $wasCached;
        // Keep the deprecated backing field in sync so wasCheckCached() stays correct.
        $this->checkCached = $wasCached;
    }

    /**
     * Set whether the sensor status was fetched from a cache
     *
     * @param bool $wasCached Whether status was cached
     * @return void
     * @deprecated Pass $wasCached to the constructor instead. Will be removed in the next major version.
     */
    public function setCheckWasCached(bool $wasCached): void
    {
        $this->checkCached = $wasCached;
    }

    /**
     * Check whether the sensor status was fetched from a cache
     *
     * @return bool Whether status was cached
     * @deprecated Use the readonly $wasCached property instead. Will be removed in the next major version.
     */
    public function wasCheckCached(): bool
    {
        return $this->checkCached;
    }

    /**
     * Check whether the sensor severity is critical
     *
     * @return bool Whether severity is critical
     */
    public function isCritical(): bool
    {
        return $this->severity === Severity::CRITICAL;
    }
}
