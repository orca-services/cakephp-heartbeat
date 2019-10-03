# Change Log
All notable changes to this project are documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/orca-services/cakephp-heartbeat/compare/2.0.0...cakephp-3.x)
### Added
- Added documentation on how to write a sensor
- Added documentation about built-in sensors
- Added CakePHP Codesniffer (PHPCS) as dev dependency

### Changed

### Dependencies
- cakephp/cakephp updated from 3.7.3 to 3.8.4
- doctrine/instantiator updated from 1.1.0 to 1.2.0
- theseer/tokenizer updated from 1.1.0 to 1.1.2
- symfony/polyfill-ctype updated from v1.9.0 to v1.11.0
- webmozart/assert updated from 1.3.0 to 1.4.0
- phpdocumentor/reflection-docblock updated from 4.3.0 to 4.3.1
- myclabs/deep-copy updated from 1.8.1 to 1.9.1
- phpunit/phpunit updated from 6.5.12 to 6.5.14
- zendframework/zend-diactoros updated from 1.8.5 to 1.8.6
- psr/log updated from 1.0.2 to 1.1.0
- cakephp/chronos updated from 1.2.2 to 1.2.5
- symfony/yaml downgraded from v4.1.4 to v3.4.27
- symfony/polyfill-mbstring updated from v1.9.0 to v1.11.0
- symfony/debug installed in version v3.4.27
- symfony/console downgraded from v4.1.4 to v3.4.27
- symfony/filesystem downgraded from v4.1.4 to v3.4.27
- symfony/config downgraded from v4.1.4 to v3.4.27
- robmorgan/phinx updated from 0.10.6 to 0.10.7
- cakephp/migrations updated from 2.0.0 to 2.1.1

### Fixed
- Fixed DB Connection Sensor

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
