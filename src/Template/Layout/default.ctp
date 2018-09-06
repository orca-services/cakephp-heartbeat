<!DOCTYPE html>
<html lang="<?php echo h(__('en')); ?>">
<head>
    <?php echo $this->Html->charset(); ?>
    <meta charset="UTF-8">
    <title><?php echo $this->fetch('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="<?php echo \Cake\Routing\Router::url('/', true); ?>">
    <?php echo $this->fetch('meta'); ?>
    <?php echo $this->Html->meta('icon', $strFavicon ?? ''); ?>
</head>
<body>
<div class="container-fluid">
    <?php echo $this->fetch('content'); ?>
</div>
</body>
</html>
