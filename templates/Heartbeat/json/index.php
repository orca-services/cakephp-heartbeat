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

$system = [$systemStatus->name => $systemStatus->message];

$statuses = $sensorStatuses->map(function ($sensorStatus) {
    /** @var Status $sensorStatus */
    $name = $sensorStatus->name;
    $status = $sensorStatus->status;
    $severity = $sensorStatus->severity;
    $duration = $sensorStatus->duration;
    $lastExecuted = $sensorStatus->lastExecuted->format('Y-m-d H:i:s');
    $wasCheckFromCache = $sensorStatus->wasCheckCached();

    $statusText = $sensorStatus->message;

    return compact('name', 'status', 'statusText', 'severity', 'duration', 'lastExecuted', 'wasCheckFromCache');
});

$heartbeat = [
    'system' => $system,
    'sensors' => $statuses,
];

echo json_encode($heartbeat, JSON_PRETTY_PRINT);
