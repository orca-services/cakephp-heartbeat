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

$systemStatusName = $systemStatus->name;
$systemStatusText = $systemStatus->status ? __('OK') : __('FAILED');

$system = [$systemStatusName => $systemStatusText];

$statuses = $sensorStatuses->map(function ($sensorStatus) {
    /** @var Status $sensorStatus */
    $name = $sensorStatus->name;
    $status = $sensorStatus->status;
    $severity = $sensorStatus->severity;
    $duration = $sensorStatus->duration;
    $lastExecuted = $sensorStatus->lastExecuted->format('Y-m-d H:i:s');
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
