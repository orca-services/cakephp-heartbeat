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
     * The name of the sensor
     */
    protected string $name;

    /**
     * The actual status
     *
     * @var mixed
     */
    protected mixed $status;

    /**
     * The sensor check duration in seconds
     */
    protected float $duration;

    /**
     * The date/time when the sensor check was last executed
     */
    protected Chronos $lastExecuted;

    /**
     * How severe the status is, e.g.
     */
    protected Severity $severity;

    /**
     * Whether sensor status was fetched from cache
     */
    protected bool $checkCached = false;

    /**
     * Status construction
     *
     * @param string $name The name of the sensor
     * @param mixed $status The actual status.
     * @param float $duration How long it took to execute the check.
     * @param Chronos $lastExecuted The date/time when it was executed last.
     * @param Severity $severity The status severity.
     */
    public function __construct(
        string $name,
        mixed $status,
        float $duration,
        Chronos $lastExecuted,
        Severity $severity,
    ) {
        $this->name = $name;
        $this->status = $status;
        $this->duration = $duration;
        $this->lastExecuted = $lastExecuted;
        $this->severity = $severity;
    }

    /**
     * Get the name of the sensor
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the sensor check status
     *
     * @return mixed
     */
    public function getStatus(): mixed
    {
        return $this->status;
    }

    /**
     * Get the sensor check duration in seconds
     *
     * @return float The sensor check duration in seconds.
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * Get the date/time when the sensor check was last executed
     *
     * @return Chronos The date/time when the sensor check was last executed.
     */
    public function getLastExecuted(): Chronos
    {
        return $this->lastExecuted;
    }

    /**
     * Get the severity of the status
     *
     * @return Severity The severity of the status.
     */
    public function getSeverity(): Severity
    {
        return $this->severity;
    }

    /**
     * Set whether the sensor status was fetched from cache
     *
     * @param bool $wasCached Whether status was cached
     * @return void
     */
    public function setCheckWasCached(bool $wasCached): void
    {
        $this->checkCached = $wasCached;
    }

    /**
     * Check whether sensor status was fetched from cache
     *
     * @return bool Whether status was cached
     */
    public function wasCheckCached(): bool
    {
        return $this->checkCached;
    }
}
