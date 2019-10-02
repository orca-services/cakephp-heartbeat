<?php

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Chronos\Chronos;

/**
 * Heartbeat Status
 */
class Status
{

    /**
     * Informational status
     */
    const STATUS_INFORMATIONAL = 1;

    /**
     * Noncritical status
     */
    const STATUS_NONCRITICAL = 2;

    /**
     * Critical status
     */
    const STATUS_CRITICAL = 3;

    /**
     * The name of the sensor
     *
     * @var string
     */
    protected $name;

    /**
     * The actual status
     *
     * @var mixed
     */
    protected $status;

    /**
     * The sensor check duration in seconds
     *
     * @var float
     */
    protected $duration;

    /**
     * The date/time when the sensor check was last executed
     *
     * @var \Cake\Chronos\Chronos
     */
    protected $lastExecuted;

    /**
     * How severe the status is, e.g.
     *
     * @var
     */
    protected $severity;

    /**
     * Whether sensor status was fetched from cache
     *
     * @var bool
     */
    protected $checkCached = false;

    /**
     * Status construction
     *
     * @param string $name The name of the sensor
     * @param mixed $status The actual status.
     * @param float $duration How long it took to execute the check.
     * @param Chronos $lastExecuted The date/time when it was executed last.
     * @param int $severity The status severity.
     */
    public function __construct($name, $status, $duration, $lastExecuted, $severity)
    {
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
    public function getStatus()
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
     * @return mixed The severity of the status.
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Set whether the sensor status was fetched from cache
     *
     * @param bool $wasCached
     */
    public function setCheckWasCached(bool $wasCached) {

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
