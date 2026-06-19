# Upgrading CakePHP Heartbeat to 4.x

This guide covers upgrading `cakephp-heartbeat` from version 3.x to 4.x to gain support for CakePHP 5.x.

```bash
composer require orca-services/cakephp-heartbeat:^4.0
```

## Breaking changes

### 1. Plugin class renamed

Following CakePHP 5 conventions, the plugin's bootstrap class was renamed. If you reference it directly anywhere (e.g. in `Application.php`):

```php
// Before
use OrcaServices\Heartbeat\Plugin;
$this->addPlugin(Plugin::class);

// After
use OrcaServices\Heartbeat\HeartbeatPlugin;
$this->addPlugin(HeartbeatPlugin::class);
```

### 2. Heartbeat configuration changed

If you configure the `DBConnection` / `DBUpToDate` sensors, update your config:

```php
// Before
'connection_name' => 'default',

// After
'connection' => 'default',
```

### 3. `cakephp/migrations` is now a `suggest` package

If your app uses the `DBUpToDate` sensor, make sure you explicitly require `cakephp/migrations` in your own application's `composer.json`.

### 4. Custom sensors may require updates

If you created custom sensors, review them for API changes:

- Status handling now uses the Severity enum instead of Integer values.
- Sensor status methods were renamed.
- Some getter methods were replaced by readonly properties.

Compare your custom sensors with the updated sensor classes before upgrading.

## Upgrade steps

1. Ensure your application runs PHP 8.2+ and CakePHP 5.3.1+.
2. Update the Heartbeat dependency.
3. Update Heartbeat configuration:
   - Rename `connection_name` to `connection`.
   - Use Severity enum instead of Integer values.
4. Install `cakephp/migrations` dependency if you use the `DBUpToDate` sensor.
5. If you reference `OrcaServices\Heartbeat\Plugin` directly, switch to `OrcaServices\Heartbeat\HeartbeatPlugin`.
6. Review custom sensors for API changes.

## Source

- PR: [#44](https://github.com/orca-services/cakephp-heartbeat/pull/44)
- Related issue: [#42](https://github.com/orca-services/cakephp-heartbeat/issues/42)
