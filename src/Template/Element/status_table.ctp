<?php
/**
 * The Heartbeat Sensor Status Table
 *
 * @var \OrcaServices\Heartbeat\Heartbeat\Sensor\Status[]|\Cake\Collection\Collection $sensorStatuses The sensor
 *     statuses.
 * @var \OrcaServices\Heartbeat\Heartbeat\Sensor\Status $systemStatus The system status.
 */

use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;

echo '<table class="table table-bordered table-responsive table-striped table-hover table-condensed">';

$sensorStatuses->some(function ($sensorStatus) {
    /** @var \OrcaServices\Heartbeat\Heartbeat\Sensor\Status $sensorStatus */
    $name = $sensorStatus->getName();
    $status = $sensorStatus->getStatus();
    $severity = $sensorStatus->getSeverity();
    $duration = $sensorStatus->getDuration();
    $lastExecuted = $sensorStatus->getLastExecuted();
    $wasCheckFromCache = $sensorStatus->wasCheckCached();

    if ($status === true) {
        $statusText = 'OK';
    } elseif ($status === false) {
        $statusText = 'FAILED';
    } else {
        $statusText = $status;
    }

    if ($status !== false) {
        if ($severity === Status::STATUS_INFORMATIONAL) {
            $tableClass = 'info';
        } else {
            $tableClass = 'success';
        }
    } else {
        if ($severity === Status::STATUS_CRITICAL) {
            $tableClass = 'danger';
        } elseif ($severity === Status::STATUS_NONCRITICAL) {
            $tableClass = 'warning';
        } else {
            $tableClass = 'info';
        }
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
