<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Heartbeat\Sensor;

use Cake\Core\Configure;
use OrcaServices\Heartbeat\Heartbeat\Sensor;

/**
 * Debug Mode Sensor
 *
 * Purely informational sensor that reports whether the debug mode is enabled.
 *
 * To treat an enabled debug mode as a failure, use the `NoDebugMode` sensor instead.
 *
 * @see NoDebugMode
 */
class DebugMode extends Sensor
{
    /**
     * Always returns `true`, regardless of the debug mode.
     *
     * @inheritDoc
     */
    protected function getStatus(): bool
    {
        return true;
    }

    /**
     * Returns whether the debug mode is enabled or disabled.
     *
     * The given status is ignored, as it is always `true`.
     *
     * @inheritDoc
     */
    protected function getStatusMessage(bool $status): string
    {
        return Configure::read('debug') ? __d('Heartbeat', 'ENABLED') : __d('Heartbeat', 'DISABLED');
    }
}
