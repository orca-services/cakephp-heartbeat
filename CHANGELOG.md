# Change Log
All notable changes to this project are documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/orca-services/cakephp-heartbeat/compare/2.0.0...cakephp-3.x)
### Added
- Added documentation on how to write a sensor
- Added documentation about built-in sensors
- Added cache indicator to sensor status #7
- Added CakePHP Codesniffer (PHPCS) as dev dependency
- Added Composer commands for executing PHPCS & PHPUnit

### Changed

### Dependencies
- cakephp/cakephp updated from 3.10.2 to 3.10.5 patch
- Downgrade numerous dependencies to be compatible with PHP >= 7.0 as stated in Installation.md
- phpunit/phpunit updated from 6.5.12 to 6.5.14
- cakephp/migrations updated from 2.0.0 to 2.4.1
- cakephp/cakephp-codesniffer updated from 3.1.2 to 3.3.3
- robmorgan/phinx updated from 0.11.6 to 0.11.7
- cakephp/cakephp updated from 3.10.3 to 3.10.4
- Various sub dependencies

### Fixed
- Fixed DB Connection Sensor
- Always reset cache config

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
