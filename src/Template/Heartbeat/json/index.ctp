<?php
/**
 * The Heartbeat Status JSON Page
 *
 * @var Status[]|Collection $sensorStatuses The sensor
 *     statuses.
 * @var Status $systemStatus The system status.
 */

use Cake\Collection\Collection;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;

$systemStatusName = $systemStatus->getName();
$systemStatusText = $systemStatus->getStatus() ? __('OK') : __('FAILED');

$system = [$systemStatusName => $systemStatusText];

$statuses = $sensorStatuses->map(function ($sensorStatus) {
    /** @var Status $sensorStatus */
    $name = $sensorStatus->getName();
    $status = $sensorStatus->getStatus();
    $severity = $sensorStatus->getSeverity();
    $duration = $sensorStatus->getDuration();
    $lastExecuted = $sensorStatus->getLastExecuted()->format('Y-m-d H:i:s');
    $wasCheckFromCache = $sensorStatus->wasCheckCached();

    if ($status === true) {
        $statusText = 'OK';
    } elseif ($status === false) {
        $statusText = 'FAILED';
    } else {
        $statusText = $status;
    }

    return compact('name', 'status', 'statusText', 'severity', 'duration', 'lastExecuted', 'wasCheckFromCache');
});

$heartbeat = [
    'system' => $system,
    'sensors' => $statuses,
];

echo json_encode($heartbeat, JSON_PRETTY_PRINT);
