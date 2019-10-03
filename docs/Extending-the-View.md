Extending the View
==================

If you need to extend the existing heartbeat status page slightly
but to not want to write your own view template to override the exiting,
you can extend the existing view.

This allows you to insert a block just before and after the
heartbeat status table.

For this, create a file at
``app/View/Plugin/Heartbeat/Heartbeat/index.ctp``
and copy the following into it:

```` php
<?php
/** @var View $this */

// Fill view block before heartbeat table
$this->start('before_heartbeat');
echo '<p>before</p>';
$this->end();

// Fill view block after heartbeat table
$this->start('after_heartbeat');
echo '<p>after</p>';
$this->end();

$this->extend('Heartbeat.heartbeat');
````

Now, you can adjust the ``before_heartbeat`` and ``after_heartbeat``
view blocks to your needs.

---

Back to the [Documentation](Home.md).
