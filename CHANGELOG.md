# Change Log
All notable changes to this project are documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/orca-services/cakephp-heartbeat/compare/2.0.0...cakephp-3.x)
### Added
- Support for CakePHP Version 4.x

### Changed

### Dependencies
- squizlabs/php_codesniffer updated from 3.10.2 to 3.13.4 minor
- phpstan/phpdoc-parser updated from 2.0.0 to 2.2.0 minor
- dealerdirect/phpcodesniffer-composer-installer installed in version v1.1.2
- phpstan/phpdoc-parser downgraded from 2.3.0 to 1.33.0 major
- slevomat/coding-standard installed in version 8.15.0
- cakephp/cakephp-codesniffer updated from 3.3.0 to 5.1.0 major
- cakephp/chronos updated from 1.3.0 to 2.4.5 major
- symfony/service-contracts downgraded from v2.5.4 to v1.1.2 major
- psr/container updated from 1.1.2 to 2.0.2 major
- psr/http-server-handler installed in version 1.0.2
- psr/http-server-middleware installed in version 1.0.2
- psr/http-client installed in version 1.0.3
- league/container installed in version 4.2.5
- psr/http-factory installed in version 1.1.0
- laminas/laminas-diactoros updated from 1.8.7p2 to 2.17.0 major
- laminas/laminas-httphandlerrunner installed in version 2.2.0
- composer/ca-bundle installed in version 1.5.8
- cakephp/cakephp updated from 3.10.5 to 4.6.2 major
- robmorgan/phinx updated from 0.11.7 to 0.13.4 minor
- cakephp/migrations updated from 2.4.2 to 3.9.0 major
- phpunit/php-token-stream updated from 2.0.2 to 4.0.4 major
- sebastian/type installed in version 1.1.5
- sebastian/resource-operations updated from 1.0.0 to 2.0.3 major
- sebastian/global-state updated from 2.0.0 to 3.0.6 major
- sebastian/environment updated from 3.1.0 to 4.2.5 major
- sebastian/diff updated from 2.0.1 to 3.0.6 major
- sebastian/comparator updated from 2.1.3 to 3.0.6 major
- phpunit/php-timer updated from 1.0.9 to 2.1.4 major
- phpunit/php-file-iterator updated from 1.4.5 to 2.0.6 major
- phpunit/php-code-coverage updated from 5.3.2 to 7.0.17 major
- phar-io/version updated from 1.0.1 to 3.2.1 major
- phar-io/manifest updated from 1.0.1 to 2.0.4 major
- phpunit/phpunit updated from 6.5.14 to 8.5.48 major

### Fixed

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
