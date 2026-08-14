<?php
/**
 * The Heartbeat Status HTML Page
 *
 * Provides a ``before_heartbeat`` & ``after_heartbeat`` view block.
 *
 * @var Status[]|Collection $sensorStatuses The sensor statuses.
 * @var Status $systemStatus The system status.
 */

use Cake\Collection\Collection;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Status;

$systemStatusLabel = $this->Html->tag(
    'span',
    $systemStatus->message,
    ['class' => 'label label-' . ($systemStatus->status ? 'success' : 'danger')]);

echo sprintf('<h1>' . $systemStatus->name . ' %s</h1>', $systemStatusLabel);
?>
<div class="row">
    <div class="col-sm-6">
        <?= $this->fetch('before_heartbeat') ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?= $this->element('status_table') ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?= $this->fetch('after_heartbeat') ?>
    </div>
</div>
