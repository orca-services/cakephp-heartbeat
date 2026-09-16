<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * Heartbeat Status Severity
 */
enum Severity: string
{
    /**
     * Critical status
     */
    case CRITICAL = 'CRITICAL';

    /**
     * Noncritical status
     */
    case NONCRITICAL = 'NONCRITICAL';

    /**
     * Informational status
     */
    case INFORMATIONAL = 'INFORMATIONAL';
}
