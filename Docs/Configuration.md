Configuration
=============

General
-------

The configuration can be set in `App.Heartbeat`.  
It takes the following subkeys:
- `name` The name of your Application (will be used for the title of the hearbeat status page)
- `layout` To override the layout (see below)
- `Sensors` an array of sensors (see below)

An example Configuration would look like this:
```php
'Heartbeat' => array(
	'name' => 'My App',
	'layout' => 'heartbeat'
	'Sensors' => array(
		'Debug-Level' => array(
			'enabled' => true,
			'severity' => 1,
			'class' => 'OrcaServices\Heartbeat\Sensor\DebugLevel',
		),
		'DB Connection' => array(
			'enabled' => true,
			'severity' => 3,
			'class' => 'OrcaServices\Heartbeat\Sensor\DBConnection',
			'cached' => true,
		),
		'DB up to date' => array(
			'enabled' => false,
			'severity' => 3,
			'class' => 'OrcaServices\Heartbeat\Sensor\DBUpToDate',
			'cached' => '+10 minutes',
		),
	),
),
```


Sensors
-------

You can add your own Sensor to your heartbeat status. See [How to write a Sensor](Sensors.md) for details.  
To add your Sensor to your status page, you have to add it to your configuration array.
The sensor array takes the names of your registered sensors as subkeys, which in turn contain configuration arrays.

Those take the following subkeys:
- `enabled` true or false, to enable or disable a sensor
- `severity` can be:
	- 1: Informational
	- 2: Non critical
	- 3: Critical
- `class` The namespace and classname of your sensor
- `chached` true, false or a string.
	 - If set to false, the value will not be cached.
	 - If set to true, the value will be cached for 30 seconds.
	 - Can be set to a relative time string e.g. '+10 minutes' to cache the value for 10 minutes.

Layout overriding
-----------------

You can override the default layout with your own to match the styling to your application.
For the example above, you should create a file named `heartbeat.ctp` in your View/Layouts folder.
There you can include javascript, css and whatever else you want, just like in a normal layout file.

---

Back to the [Documentation](Home.md).
