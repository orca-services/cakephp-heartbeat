Built-in Sensors
================

#### DB Connection
Checks whether a connection to the database server of the `default` connection can be established.

To check a connection other than ``default``, e.g. ``external``,
the ``connection``setting can be used.

```php
$config['App']['Heartbeat']['Sensors']['External DB Connection'] = [
    'enabled' => true,
    'severity' => Severity::CRITICAL,
    'class' => DBConnection::class,
    'cached' => true,
    'settings' => [
        'connection' => 'external'
    ],
];
```

#### DB Up to date
Uses the Migrations Plugin to check whether all migrations have been run.

If you use a version of cakephp/migrations below 2.2, you will need to load
the cakephp/migrations plugin before the sensor is called.

By default, the sensor checks the application's own migrations on the ``default``
connection. The following settings can be used to point it elsewhere:

- ``connection`` The datasource connection to check. Defaults to ``default``.
- ``source`` The folder the migration files live in. Defaults to ``Migrations``.
- ``plugin`` The plugin that contains the migrations. Defaults to `null`. When omitted, the
  application's migrations are checked.

To check the migrations of a plugin (e.g. ``MyPlugin``) on a connection other
than ``default``, e.g. ``external``, the settings can be used like this:

```php
$config['App']['Heartbeat']['Sensors']['Plugin DB up to date'] = [
    'enabled' => true,
    'severity' => Severity::CRITICAL,
    'class' => DBUpToDate::class,
    'cached' => '+10 minutes',
    'settings' => [
        'connection' => 'external',
        'source' => 'MyMigrations',
        'plugin' => 'MyPlugin',
    ],
];
```

#### Debug Mode
Outputs the configuration for the debug mode.


How to Write a Heartbeat Sensor
===============================

If you would like to add a new sensor to the heartbeat, e.g. to monitor an API,
you can do that easily. In this example, we will add a sensor for 'My API'.

First, create a class for the sensor wherever you like, e.g. ``src/Heartbeat/Sensor``.
The class for this example will be named ``MyApi``.
This class has to extend ``OrcaServices\Heartbeat\Heartbeat\Sensor``
and implement the abstract method ``getStatus()`` and optionally overwrite the  ``getStatusMessage()`` method.

``getStatus()`` returns `true` or `false` to imply whether the action to check was successful.

``getStatusMessage()`` receives the boolean result of ``getStatus()`` and returns the status message that is shown in the status column of the heartbeat table.

If your sensor reads configurable settings, declare their defaults in the ``$defaultSettings`` property and read them with ``$this->getSetting('name')``.
The [settings configured]Configuration.md) under the ``settings`` key are merged on top of the defaults, so a configured value always wins:

```php
// In your sensor class:
protected array $defaultSettings = [
    'connection' => 'default',
];

// Read a setting (returns 'default' unless overridden via the `settings` config):
$connectionName = $this->getSetting('connection');
```

We assume that, to check the API status, we have an ``ApiClient`` class somewhere in the project
and that class has a method called ``ping()`` which returns 'Pong' as answer from the API.

In this example, the Sensor would look like this:
```php
<?php
namespace Heartbeat\Sensor;

use Exception;
use OrcaServices\Heartbeat\Heartbeat\Sensor;
use Api\ApiClient;

class MyApi extends Sensor
{
    protected function getStatus(): bool
    {
        try {
            $client = new ApiClient();
            $ping = $client->ping();

            return $ping['message'] == 'Pong';
        } catch (Exception $exception) {
            return false;
        }
    }

    protected function getStatusMessage(bool $status): string
    {
        return $status ? __d('Heartbeat', 'OK') : __d('Heartbeat', 'FAILED');
    }
}
```

Now we just have to load our new sensor in the [configuration](Configuration.md), e.g:
```php
$config['App']['Heartbeat'] = [
    'name' => 'My App',
    'layout' => 'heartbeat',
    'Sensors' => [
        'Debug-Mode' => [
            'enabled' => true,
            'severity' => Severity::INFORMATIONAL,
            'class' => DebugMode::class,
        ],
        'DB Connection' => [
            'enabled' => true,
            'severity' => Severity::CRITICAL,
            'class' => DBConnection::class,
            'cached' => true,
        ],
        'DB up to date' => [
            'enabled' => false,
            'severity' => Severity::CRITICAL,
            'class' => DBUpToDate::class,
            'cached' => '+10 minutes',
        ],
        'REST API' => [
            'enabled' => true,
            'severity' => Severity::NONCRITICAL,
            'class' => Heartbeat\Sensor\MyApi::class,
            'cached' => '+15 minutes',
        ],
    ],
];
```

---

Back to the [Documentation](Home.md).
