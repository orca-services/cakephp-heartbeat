Configuration
=============

General
-------

The configuration can be set in `App.Heartbeat`.  
It takes the following subkeys:
- `name` The name of your application (will be used for the title of the hearbeat status page)
- `layout` To override the layout (see below)
- `Sensors` an array of sensors (see below)

An example configuration would look like this:
```php
    'Heartbeat' => [
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
            ],
            'DB up to date' => [
                'enabled' => false,
                'severity' => 3,
                'class' => OrcaServices\Heartbeat\Heartbeat\Sensor\DBUpToDate::class,
                'cached' => '+10 minutes',
            ],
        ],
    ],
```


Sensors
-------

You can add your own sensor to your heartbeat status. See [How to write a Sensor](Sensors.md) for details.  
To add your sensor to your status page, you have to add it to your configuration array.
The sensor array takes the names of your registered sensors as subkeys, which in turn contain configuration arrays.

Those take the following subkeys:
- `enabled` true or false, to enable or disable a sensor
- `severity` can be:
	- 1: Informational
	- 2: Non critical
	- 3: Critical
- `class` The fully qualified class name (FQCN)
- `chached` true, false or a string.
	 - If set to false, the value will not be cached.
	 - If set to true, the value will be cached for 30 seconds (by default).
	 - Can be set to a relative time string e.g. '+10 minutes' to cache the value for 10 minutes.

Layout overriding
-----------------

You can override the default layout with your own to match the styling of your application.
For the example above, you should create a file named `heartbeat.ctp` in your View/Layouts folder.
In there, you can define a custom layout and load custom assets, such as JavaScript & CSS.

---

Back to the [Documentation](Home.md).
