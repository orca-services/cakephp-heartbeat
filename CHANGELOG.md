# Change Log
All notable changes to this project are documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/orca-services/cakephp-heartbeat)
### Added
- Add public readonly `Status::$wasCached` property to expose whether the sensor status was fetched from cache [#48](https://github.com/orca-services/cakephp-heartbeat/issues/48)

### Changed

### Removed
- Remove `Status::setCheckWasCached()` and `Status::wasCheckCached()`. Use the readonly `Status::$wasCached` property instead [#48](https://github.com/orca-services/cakephp-heartbeat/issues/48)

### Dependencies

### Fixed

## [4.0.0](https://github.com/orca-services/cakephp-heartbeat/releases/tag/4.0.0) - 2026-08-17
### Added
- Add optional config setting `environment` to append the application environment to the heartbeat status page title [#45](https://github.com/orca-services/cakephp-heartbeat/issues/45)
- Add `getStatusMessage()` method to `Sensor` so each sensor can provide its own human-readable status messages [#45](https://github.com/orca-services/cakephp-heartbeat/issues/45)
- Add `Sensor::$defaultSettings` so sensors can declare default settings that are merged with (and overridden by) the settings from the configuration [#45](https://github.com/orca-services/cakephp-heartbeat/issues/45)

### Changed
- Bump support for CakePHP to 5.x [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)
- Update the minimum required PHP Version to PHP 8.2 [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)
- Rename config setting `connection_name` to `connection` [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)
- Some getter methods were replaced by readonly properties [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)
- Sensor status methods were renamed to get rid of the `_` prefix [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)
- Rename Heartbeat Plugin class name to match CakePHP 5 convention [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)
- Status handling now uses the `Severity` enum instead of integer values [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)
- Move the sensor status text out of the status table template into the sensors [#45](https://github.com/orca-services/cakephp-heartbeat/issues/45)

### Dependencies
- cakephp/migrations updated from 3.9.0 to 5.2.6 major [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)
- cakephp/cakephp updated from 4.6.4 to 5.4.1 major [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)
- cakephp/cakephp-codesniffer updated from 4.7.1 to 5.3.1 major [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)
- phpunit/phpunit updated from 9.6.34 to 10.5.64 major [#44](https://github.com/orca-services/cakephp-heartbeat/issues/44)

## [3.2.0](https://github.com/orca-services/cakephp-heartbeat/releases/tag/3.2.0) - 2026-06-17
### Added
- Make DB connection name for DBUpToDate sensor configurable [#40](https://github.com/orca-services/cakephp-heartbeat/issues/40)

## [3.1.0](https://github.com/orca-services/cakephp-heartbeat/releases/tag/3.1.0) - 2026-06-15
### Added
- Make DB connection name configurable [#14](https://github.com/orca-services/cakephp-heartbeat/issues/14)
- Implement the Cake InstanceConfigTrait [#14](https://github.com/orca-services/cakephp-heartbeat/issues/14)

### Changed
- Update the minimum required PHP Version to PHP 7.4
- Exclude repository-only files from archives to reduce Composer distribution package size [#37](https://github.com/orca-services/cakephp-heartbeat/issues/37)

### Dependencies
- phpunit/phpunit updated from 9.6.29 to 9.6.34 patch
- cakephp/cakephp updated from 4.6.2 to 4.6.4 patch
- cakephp/cakephp-codesniffer downgraded from 5.1.0 to 4.7.1 major

## [3.0.4](https://github.com/orca-services/cakephp-heartbeat/releases/tag/3.0.4) - 2025-01-06
### Fixed
- JSON view fixed

## [3.0.3](https://github.com/orca-services/cakephp-heartbeat/releases/tag/3.0.3) - 2025-01-06
### Fixed
- Changed the case of letters in the names of template folders

## [3.0.2](https://github.com/orca-services/cakephp-heartbeat/releases/tag/3.0.2) - 2025-01-06
### Changed
- Move template's folder to standard CakePHP location
- Rename '.ctp' extension to '.php' for all templates

### Fixed
- Resolve CakePHP deprecation by getting database connection

## [3.0.1](https://github.com/orca-services/cakephp-heartbeat/releases/tag/3.0.1) - 2025-11-11
### Fixed
- Fix CakePHP and PHPUnit deprecations

## [3.0.0](https://github.com/orca-services/cakephp-heartbeat/releases/tag/3.0.0) - 2025-11-04
### Added
- Upgrade to CakePHP version 4.x
- Add visibility for constants
- Add data type hints for parameters & return values

### Changed
- Refactoring code according to the code style

### Dependencies
- cakephp/cakephp updated from 3.10.5 to 4.6.2 major
- cakephp/cakephp-codesniffer updated from 3.3.0 to 5.1.0 major
- cakephp/chronos updated from 1.3.0 to 2.4.5 major
- cakephp/migrations updated from 2.4.2 to 3.9.0 major
- composer/ca-bundle installed in version 1.5.8
- dealerdirect/phpcodesniffer-composer-installer installed in version v1.1.2
- laminas/laminas-diactoros updated from 1.8.7p2 to 2.17.0 major
- laminas/laminas-httphandlerrunner installed in version 2.2.0
- league/container installed in version 4.2.5
- nikic/php-parser installed in version v5.6.2
- phar-io/manifest updated from 1.0.1 to 2.0.4 major
- phar-io/version updated from 1.0.1 to 3.2.1 major
- phpstan/phpdoc-parser downgraded from 2.0.0 to 1.33.0 major
- phpunit/php-code-coverage updated from 5.3.2 to 9.2.32 major
- phpunit/php-code-coverage updated from 7.0.17 to 9.2.32 major
- phpunit/php-file-iterator updated from 1.4.5 to 3.0.6 major
- phpunit/php-invoker installed in version 3.1.1
- phpunit/php-text-template updated from 1.2.1 to 2.0.4 major
- phpunit/php-timer updated from 1.0.9 to 5.0.3 major
- phpunit/php-token-stream removed (installed version was 2.0.2)
- phpunit/phpunit updated from 6.5.14 to 9.6.29 major
- psr/container updated from 1.1.2 to 2.0.2 major
- psr/http-client installed in version 1.0.3
- psr/http-factory installed in version 1.1.0
- psr/http-server-handler installed in version 1.0.2
- psr/http-server-middleware installed in version 1.0.2
- robmorgan/phinx updated from 0.11.7 to 0.13.4 minor
- sebastian/cli-parser installed in version 1.0.2
- sebastian/code-unit installed in version 1.0.8
- sebastian/code-unit-reverse-lookup updated from 1.0.3 to 2.0.3 major
- sebastian/comparator updated from 2.1.3 to 4.0.9 major
- sebastian/complexity installed in version 2.0.3
- sebastian/diff updated from 2.0.1 to 4.0.6 major
- sebastian/environment updated from 3.1.0 to 5.1.5 major
- sebastian/exporter updated from 3.1.8 to 4.0.8 major
- sebastian/global-state updated from 2.0.0 to 5.0.8 major
- sebastian/lines-of-code installed in version 1.0.4
- sebastian/object-enumerator updated from 3.0.5 to 4.0.4 major
- sebastian/object-reflector updated from 1.1.3 to 2.0.4 major
- sebastian/recursion-context updated from 3.0.3 to 4.0.6 major
- sebastian/resource-operations updated from 1.0.0 to 3.0.4 major
- sebastian/type installed in version 3.2.1
- sebastian/version updated from 2.0.1 to 3.0.2 major
- slevomat/coding-standard installed in version 8.15.0
- squizlabs/php_codesniffer updated from 3.10.2 to 3.13.4 minor
- symfony/service-contracts downgraded from v2.5.4 to v1.1.2 major

## [2.2.1](https://github.com/orca-services/cakephp-heartbeat/releases/tag/2.2.1) - 2024-7-29
### Fixed
- Set table cell options for cache indicator

## [2.2.0](https://github.com/orca-services/cakephp-heartbeat/releases/tag/2.2.0) - 2024-7-29
### Added
- Added cache indicator to sensor status #7 #22
- Added CakePHP Codesniffer (PHPCS) as dev dependency #25
- Added Composer commands for executing PHPCS & PHPUnit #25
- Add a security policy file #26 #28

### Changed
- Improve readability of configuration in #24
- Move CONTRIBUTING.md to .github folder #27

### Dependencies
- cakephp/cakephp updated from 3.7.7 to 3.10.5 minor
- Downgrade numerous dependencies to be compatible with PHP >= 7.0 as stated in Installation.md
- cakephp/migrations updated from 2.0.0 to 2.4.1
- cakephp/cakephp-codesniffer updated from 3.1.2 to 3.3.3
- robmorgan/phinx updated from 0.11.6 to 0.11.7
- Various sub dependencies
- squizlabs/php_codesniffer updated from 3.8.1 to 3.10.2 minor

### Fixed
- Always reset cache config

## [2.1.0](https://github.com/orca-services/cakephp-heartbeat/releases/tag/2.1.0) - 2019-6-26
### Added
- Added documentation on how to write a sensor
- Add documentation about built-in sensors #15 #16

### Changed
- Compatibility to CakePHP 3.7.x #17, #18, #19, #20, #21
- Bump CakePHP requirement to 3.7.0 #19, #21
- Do not load Migrations plugin in DBUpToDate sensor # 18, #20

### Fixed
- Fixed DB Connection Sensor #13
- Fixed Sensor cache reading #21

### Dependencies
- phpunit/phpunit updated from 6.5.12 to 6.5.14

## [2.0.0](https://github.com/orca-services/cakephp-heartbeat/releases/tag/2.0.0) - 2018-10-01
### Added
- Support for CakePHP Version 3.x
- Add CakePHP Migrations plugin as development dependency

### Changed
- Load CakePHP Migrations plugin in DBUpToDate sensor, if not loaded already

### Fixed
- Update minimum required PHP Version to PHP 5.4

## [0.1.1](https://github.com/orca-services/cakephp-heartbeat/releases/tag/0.1.1) - 2017-07-20
### Changed
-  Improved reading of default Cache settings

## [0.1.0](https://github.com/orca-services/cakephp-heartbeat/releases/tag/0.1.0) - 2017-04-21
### Added
- Initial functionality with Heartbeat controller providing a HTML & JSON template, the core logic and some built-in sensors
