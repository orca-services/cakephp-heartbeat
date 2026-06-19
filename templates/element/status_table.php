<?php
/**
 * The Heartbeat Sensor Status Table
 *
 * @var Status[]|Collection $sensorStatuses The sensor statuses.
 * @var Status $systemStatus The system status.
 */

use Cake\Collection\Collection;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Severity;

echo '<table class="table table-bordered table-responsive table-striped table-hover table-condensed">';

$sensorStatuses->some(function ($sensorStatus) {
    /** @var Status $sensorStatus */
    $name = $sensorStatus->name;
    $status = $sensorStatus->status;
    $severity = $sensorStatus->severity;
    $duration = $sensorStatus->duration;
    $lastExecuted = $sensorStatus->lastExecuted;
    $wasCheckFromCache = $sensorStatus->wasCheckCached();

    $statusText = match ($status) {
        true => 'OK',
        false => 'FAILED',
        default => $status,
    };

    if ($status === true) {
        $tableClass = match ($severity) {
            Severity::INFORMATIONAL => 'info',
            default => 'success',
        };
    } else {
        $tableClass = match ($severity) {
            Severity::CRITICAL => 'danger',
            Severity::NONCRITICAL => 'warning',
            Severity::INFORMATIONAL => 'info',
        };
    }

    echo $this->Html->tableCells([
        [
            $name,
            [
                $statusText,
                ['class' => $tableClass],
            ],
            [
                sprintf('%s s', $duration),
                ['class' => $tableClass],
            ],
            [
                $lastExecuted,
                ['class' => $tableClass],
            ],
            [
                $wasCheckFromCache ? 'Cached' : 'Not cached',
                ['class' => $tableClass],
            ],
        ],
    ]);
});

echo '</table>';
