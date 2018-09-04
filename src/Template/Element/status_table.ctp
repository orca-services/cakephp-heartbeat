<?php
/**
 * The Heartbeat Sensor Status Table
 *
 * @var \OrcaServices\Heartbeat\Sensor\Status[]|\Cake\Collection\Collection $sensorStatuses The sensor statuses.
 * @var \OrcaServices\Heartbeat\Sensor\Status $systemStatus The system status.
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

	if ($status === true) {
		$statusText = 'OK';
	} elseif ($status === false) {
		$statusText = 'FAILED';
	} else {
		$statusText = $status;
	}

	if ($status !== false) {
		if ($severity ===  Status::STATUS_INFORMATIONAL) {
			$tableClass = 'info';
		} else {
			$tableClass = 'success';
		}
	} else {
		if ($severity ===  Status::STATUS_CRITICAL) {
			$tableClass = 'danger';
		} elseif ($severity ===  Status::STATUS_NONCRITICAL) {
			$tableClass = 'warning';
		} else {
			$tableClass = 'info';
		}
	}

	echo $this->Html->tableCells(array(
		array(
			$name,
			array(
				$statusText,
				array('class' => $tableClass),
			),
			array(
				sprintf('%s s', $duration),
				array('class' => $tableClass),
			),
			array(
				$lastExecuted,
				array('class' => $tableClass),
			),
		),
	));
});

echo '</table>';
