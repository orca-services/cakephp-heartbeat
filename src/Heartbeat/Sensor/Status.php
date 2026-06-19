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
        public readonly string $name,
        public readonly mixed $status,
        public readonly float $duration,
        public readonly Chronos $lastExecuted,
        public readonly Severity $severity,
    ) {
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
