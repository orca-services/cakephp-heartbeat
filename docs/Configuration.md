Configuration
=============

General
-------

The configuration can be set in `App.Heartbeat`.
It takes the following subkeys:
- `name` The name of your application (will be used for the title of the hearbeat status page)
- `layout` To override the layout (see below)
- `Sensors` An array of sensors (see below)

An example configuration would look like this:
```php
$config['App']['Heartbeat'] = [
    'name' => 'My App',
    'layout' => 'heartbeat',
    'Sensors' => [
        'Debug-Mode' => [
            'enabled' => true,
            'severity' => 1,
            'class' => OrcaServices\Heartbeat\Heartbeat\Sensor\DebugMode::class,
        ],
        'DB Connection' => [
            'enabled' => true,
            'severity' => 3,
            'class' => OrcaServices\Heartbeat\Heartbeat\Sensor\DBConnection::class,
            'cached' => true,
            'settings' => [
                'connection' => 'default',
            ],
        ],
        'DB up to date' => [
            'enabled' => false,
            'severity' => 3,
            'class' => OrcaServices\Heartbeat\Heartbeat\Sensor\DBUpToDate::class,
            'cached' => '+10 minutes',
            'settings' => [
                'connection' => 'default',
                'source' => 'Migrations',
                'plugin' => 'MyPlugin',
            ],
        ],
    ],
];
```


Sensors
-------

You can add your own sensor to your heartbeat status. See [How to write a Sensor](Sensors.md) for details.
To add your sensor to your status page, you have to add it to your configuration array.
The sensor array takes the names of your registered sensors as subkeys, which in turn contain configuration arrays.

Those take the following subkeys:
- `enabled` can be `true` or `false`; to enable or disable a sensor
- `severity` can be:
    - `1`: Informational
    - `2`: Non critical
    - `3`: Critical
- `class` The fully qualified class name (FQCN)
- `cached` `true`, `false` or a string
    - If set to `false`, the value will not be cached.
    - If set to `true`, the value will be cached for 30 seconds (by default).
    - Can be set to a relative time string e.g. `+10 minutes` to cache the value for 10 minutes.
- `settings` Additional settings for the sensor. e.g. the name of the database connection to test.

Conditional Severity
--------------------
Sometimes you may want the severity of a sensor to differ depending on the time of day, day of the week, or any other date-related condition. For example, an API may be critical during business hours when customers are active, but only non-critical on weekends.

There are two ways to make it dynamic:

**1. Compute the severity beforehand using a conditional**

Set the severity value via a simple `if` clause or ternary before defining the configuration array:

```php
use \OrcaServices\Heartbeat\Heartbeat\Sensor;

$conditionalSeverity = Sensor::STATUS_NONCRITICAL;
if ($specialDateOrTimeOfDay) {
    $conditionalSeverity = Sensor::STATUS_CRITICAL;
}

$config['App']['Heartbeat'] = [
    'name' => 'My App',
    'layout' => 'heartbeat',
    'Sensors' => [
        'Sensor with conditional Severity' => [
            'enabled' => true,
            'severity' => $conditionalSeverity,
            'class' => Some\Sensor\Class,
        ],
    ],
];
```

**2. Pass a callable (e.g. a closure)**

You can also assign a closure to `severity`, which will be invoked to determine the severity at runtime:

```php
use \OrcaServices\Heartbeat\Heartbeat\Sensor;

$conditionalSeverity = function() use ($specialDateOrTimeOfDay) {
    if ($specialDateOrTimeOfDay) {
        return Sensor::STATUS_CRITICAL;
    }
    return Sensor::STATUS_NONCRITICAL;
};

$config['App']['Heartbeat'] = [
    'name' => 'My App',
    'layout' => 'heartbeat',
    'Sensors' => [
        'Sensor with conditional Severity' => [
            'enabled' => true,
            'severity' => $conditionalSeverity,
            'class' => Some\Sensor\Class,
        ],
    ],
];
```

Layout overriding
-----------------

You can override the default layout with your own to match the styling of your application.
For the example above, you should create a file named `heartbeat.php` in your View/Layouts folder.
In there, you can define a custom layout and load custom assets, such as JavaScript & CSS.

---

Back to the [Documentation](Home.md).
