<?php
/**
 * The Heartbeat Status HTML Page
 *
 * Provides a ``before_heartbeat`` & ``after_heartbeat`` view block.
 *
 * @var \OrcaServices\Heartbeat\Heartbeat\Sensor\Status[]|\Cake\Collection\Collection $sensorStatuses The sensor
 *     statuses.
 * @var \OrcaServices\Heartbeat\Heartbeat\Sensor\Status $systemStatus The system status.
 */

$systemStatusLabel = $this->Html->tag(
    'span',
    $systemStatus->getStatus() ? __('OK') : __('FAILED'),
    ['class' => 'label label-' . ($systemStatus->getStatus() ? 'success' : 'danger')]);

echo sprintf('<h1>' . $systemStatus->getName() . ' %s</h1>', $systemStatusLabel);
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $this->fetch('before_heartbeat'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php echo $this->element('status_table'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php echo $this->fetch('after_heartbeat'); ?>
    </div>
</div>
