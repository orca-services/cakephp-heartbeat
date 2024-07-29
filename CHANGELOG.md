# Change Log
All notable changes to this project are documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/orca-services/cakephp-heartbeat/compare/2.0.0...cakephp-3.x)
### Added

### Changed

### Dependencies

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
