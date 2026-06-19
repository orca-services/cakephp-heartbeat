<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * Heartbeat Status Severity
 */
enum Severity
{
    /**
     * Critical status
     */
    case CRITICAL;

    /**
     * Noncritical status
     */
    case NONCRITICAL;

    /**
     * Informational status
     */
    case INFORMATIONAL;
}
