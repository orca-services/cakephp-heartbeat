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
     * @var Chronos  The date/time when the sensor check was last executed
     */
    public readonly Chronos $lastExecuted;

    /**
     * @var Severity How severe the status is, e.g. critical
     */
    public readonly Severity $severity;

    /**
     * @var bool Whether sensor status was fetched from cache
     */
    protected bool $checkCached = false;

    /**
     * Status construction
     *
     * @param string $name The name of the sensor
     * @param bool $status The actual status.
     * @param float $duration How long it took to execute the check.
     * @param Chronos $lastExecuted The date/time when it was executed last.
     * @param Severity $severity The status severity.
     * @param string $message The human-readable status message.
     */
    public function __construct(
        string $name,
        bool $status,
        float $duration,
        Chronos $lastExecuted,
        Severity $severity,
        string $message,
    ) {
        $this->severity = $severity;
        $this->lastExecuted = $lastExecuted;
        $this->duration = $duration;
        $this->status = $status;
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * Set whether the sensor status was fetched from a cache
     *
     * @param bool $wasCached Whether status was cached
     * @return void
     */
    public function setCheckWasCached(bool $wasCached): void
    {
        $this->checkCached = $wasCached;
    }

    /**
     * Check whether the sensor status was fetched from a cache
     *
     * @return bool Whether status was cached
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
