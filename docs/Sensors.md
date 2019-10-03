Built-in Sensors
================

#### DB Connection
Checks whether a connection to the database server can be established.

#### DB Up to date
Uses the Migrations Plugin to check whether all migrations have been run.

If you use a version of cakephp/migrations below 2.2, you will need to load
the cakephp/migrations plugin before the sensor is called.

#### Debug Mode
Outputs the configuration for the debug mode.


How to Write a Heartbeat Sensor
===============================

If you would like to add a new sensor to the heartbeat, e.g. to monitor an API,
you can do that easily. In this example, we will add a sensor for 'My API'.

First, create a class for the sensor wherever you like, e.g. ``src/Heartbeat/Sensor``.
The class for this example will be named ``MyApi``.
This class has to extend ``OrcaServices\Heartbeat\Heartbeat\Sensor``
and implement the abstract method ``_getStatus()``.

In most cases, this method should return true or false to imply whether the action to check was successful or not.
It can also return other, purely informational data, e.g. the version number,
but that only makes sense for an informational status (as defined in the [configuration](Configuration.md)).

We assume that, to check the API status, we have an ``ApiClient`` class somewhere in the project
and that class has a method called ``ping()`` which returns 'Pong' as answer from the API.

In this example, the Sensor would look like this:
```` php
<?php
namespace Heartbeat\Sensor;

use Exception;
use OrcaServices\Heartbeat\Heartbeat\Sensor;
use Api\ApiClient;

class MyApi extends Sensor
{
    protected function _getStatus()
    {
        try {
            $client = new ApiClient();
            $ping = $client->ping();

            return $ping['message'] == 'Pong';
        } catch (Exception $exception) {
            return false;
        }
    }
}
````

Now we just have to load our new sensor in the [configuration](Configuration.md), e.g:
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
        ],
        'DB up to date' => [
            'enabled' => false,
            'severity' => 3,
            'class' => OrcaServices\Heartbeat\Heartbeat\Sensor\DBUpToDate::class,
            'cached' => '+10 minutes',
        ],
        'REST API' => [
            'enabled' => true,
            'severity' => 2,
            'class' => Heartbeat\Sensor\MyApi::class,
            'cached' => '+15 minutes',
        ],
    ],
];
```

---

Back to the [Documentation](Home.md).
