<?php

/**
 * Heartbeat default layout template
 *
 * @var View $this View
 */

use Cake\Routing\Router;
use Cake\View\View;

?>
<!DOCTYPE html>
<html lang="<?= h(__('en')) ?>">
<head>
    <?= $this->Html->charset() ?>
    <title><?= $this->fetch('title') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="<?= Router::url('/', true) ?>">
    <?= $this->fetch('meta') ?>
    <?= $this->Html->meta('icon', $strFavicon ?? '') ?>
</head>
<body>
<div class="container-fluid">
    <?= $this->fetch('content') ?>
</div>
</body>
</html>
