<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat\Sensor;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Config;
use OrcaServices\Heartbeat\Heartbeat\Sensor\DebugModeByEnvironment;
use OrcaServices\Heartbeat\Heartbeat\Sensor\Severity;

/**
 * Debug Mode by Environment Sensor Test
 *
 * @coversDefaultClass \OrcaServices\Heartbeat\Heartbeat\Sensor\DebugModeByEnvironment
 */
class DebugModeByEnvironmentTest extends TestCase
{
    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        Configure::delete('App.Heartbeat.environment');
    }

    /**
     * Builds a configured DebugModeByEnvironment sensor.
     *
     * @param array $settings Sensor settings
     * @return DebugModeByEnvironment
     */
    private function createSensor(array $settings = []): DebugModeByEnvironment
    {
        $config = new Config('Debug-Mode by Environment', [
            'enabled' => true,
            'severity' => Severity::CRITICAL,
            'class' => DebugModeByEnvironment::class,
            'settings' => $settings,
        ]);

        return new DebugModeByEnvironment($config);
    }

    /**
     * Provides every default environment combined with both debug modes.
     *
     * @return array<string, array{string, bool, bool}> Environment, debug mode, expected status
     */
    public static function defaultEnvironmentsProvider(): array
    {
        return [
            'dev, debug enabled' => ['dev', true, true],
            'dev, debug disabled' => ['dev', false, false],
            'development, debug enabled' => ['development', true, true],
            'development, debug disabled' => ['development', false, false],
            'test, debug enabled' => ['test', true, false],
            'test, debug disabled' => ['test', false, true],
            'testing, debug enabled' => ['testing', true, false],
            'testing, debug disabled' => ['testing', false, true],
            'staging, debug enabled' => ['staging', true, false],
            'staging, debug disabled' => ['staging', false, true],
            'prod, debug enabled' => ['prod', true, false],
            'prod, debug disabled' => ['prod', false, true],
            'production, debug enabled' => ['production', true, false],
            'production, debug disabled' => ['production', false, true],
        ];
    }

    /**
     * The status is true only if the debug mode matches the default expectation of the environment.
     *
     * @param string $environment The environment.
     * @param bool $debug The current debug mode.
     * @param bool $expectedStatus The expected sensor status.
     * @return void
     * @dataProvider defaultEnvironmentsProvider
     * @covers ::getStatus
     * @covers ::getExpectedDebugMode
     * @covers ::getEnvironmentExpectations
     */
    public function testGetStatusForDefaultEnvironments(string $environment, bool $debug, bool $expectedStatus): void
    {
        Configure::write('debug', $debug);

        $sensorStatus = $this->createSensor(['environment' => $environment])->getSensorStatus();

        $this->assertSame($expectedStatus, $sensorStatus->status);
    }

    /**
     * The status message reflects the current debug mode, not the status.
     *
     * @return void
     * @covers ::getStatusMessage
     * @covers ::isDebugModeEnabled
     */
    public function testGetStatusMessageReflectsDebugMode(): void
    {
        Configure::write('debug', true);
        $enabledOnProd = $this->createSensor(['environment' => 'production'])->getSensorStatus();
        $this->assertFalse($enabledOnProd->status);
        $this->assertSame('ENABLED', $enabledOnProd->message);

        Configure::write('debug', false);
        $disabledOnProd = $this->createSensor(['environment' => 'production'])->getSensorStatus();
        $this->assertTrue($disabledOnProd->status);
        $this->assertSame('DISABLED', $disabledOnProd->message);

        $disabledOnDev = $this->createSensor(['environment' => 'development'])->getSensorStatus();
        $this->assertFalse($disabledOnDev->status);
        $this->assertSame('DISABLED', $disabledOnDev->message);
    }

    /**
     * Without an `environment` setting, `App.Heartbeat.environment` is used.
     *
     * @return void
     * @covers ::getEnvironment
     */
    public function testGetStatusFallsBackToHeartbeatEnvironmentConfig(): void
    {
        Configure::write('App.Heartbeat.environment', 'Development');
        Configure::write('debug', true);

        $this->assertTrue($this->createSensor()->getSensorStatus()->status);

        Configure::write('debug', false);

        $this->assertFalse($this->createSensor()->getSensorStatus()->status);
    }

    /**
     * The `environment` setting takes precedence over `App.Heartbeat.environment`.
     *
     * @return void
     * @covers ::getEnvironment
     */
    public function testEnvironmentSettingOverridesHeartbeatEnvironmentConfig(): void
    {
        Configure::write('App.Heartbeat.environment', 'Development');
        Configure::write('debug', true);

        $sensorStatus = $this->createSensor(['environment' => 'Production'])->getSensorStatus();

        $this->assertFalse($sensorStatus->status);
    }

    /**
     * Environment names are matched case-insensitively and surrounding whitespace is ignored.
     *
     * @return void
     * @covers ::getEnvironment
     * @covers ::getExpectedDebugMode
     */
    public function testEnvironmentIsCaseInsensitiveAndTrimmed(): void
    {
        Configure::write('debug', true);

        $this->assertTrue($this->createSensor(['environment' => 'DEVELOPMENT'])->getSensorStatus()->status);
        $this->assertTrue($this->createSensor(['environment' => '  Dev  '])->getSensorStatus()->status);
        $this->assertFalse($this->createSensor(['environment' => ' Production '])->getSensorStatus()->status);
    }

    /**
     * Provides environments that cannot be determined or are not mapped.
     *
     * @return array<string, array{mixed}> Environment
     */
    public static function unknownEnvironmentProvider(): array
    {
        return [
            'not configured' => [null],
            'empty string' => [''],
            'whitespace only' => ['   '],
            'not a string' => [42],
            'unmapped environment' => ['qa'],
        ];
    }

    /**
     * An unknown environment expects the debug mode to be disabled (fail-safe).
     *
     * @param mixed $environment The environment.
     * @return void
     * @dataProvider unknownEnvironmentProvider
     * @covers ::getEnvironment
     * @covers ::getExpectedDebugMode
     */
    public function testUnknownEnvironmentExpectsDebugModeDisabled(mixed $environment): void
    {
        Configure::write('App.Heartbeat.environment', $environment);

        Configure::write('debug', false);
        $this->assertTrue($this->createSensor()->getSensorStatus()->status);

        Configure::write('debug', true);
        $this->assertFalse($this->createSensor()->getSensorStatus()->status);
    }

    /**
     * Configured environments can override the defaults and add new environments.
     *
     * @return void
     * @covers ::getEnvironmentExpectations
     */
    public function testCustomEnvironments(): void
    {
        $environments = [
            'staging' => true,
            'QA' => true,
            'production' => false,
        ];
        Configure::write('debug', true);

        $this->assertTrue($this->createSensor([
            'environment' => 'staging',
            'environments' => $environments,
        ])->getSensorStatus()->status);
        $this->assertTrue($this->createSensor([
            'environment' => 'qa',
            'environments' => $environments,
        ])->getSensorStatus()->status);
        $this->assertFalse($this->createSensor([
            'environment' => 'production',
            'environments' => $environments,
        ])->getSensorStatus()->status);
    }

    /**
     * Configured environments replace the default environments entirely.
     *
     * @return void
     * @covers ::getEnvironmentExpectations
     */
    public function testCustomEnvironmentsReplaceDefaults(): void
    {
        Configure::write('debug', true);

        $sensorStatus = $this->createSensor([
            'environment' => 'development',
            'environments' => ['qa' => true],
        ])->getSensorStatus();

        $this->assertFalse($sensorStatus->status);
    }

    /**
     * Entries with an empty name or a non-boolean expectation are ignored.
     *
     * @return void
     * @covers ::getEnvironmentExpectations
     */
    public function testInvalidEnvironmentEntriesAreIgnored(): void
    {
        $environments = [
            'qa' => 'yes',
            'uat' => 1,
            '' => true,
            '  ' => true,
            'local' => true,
        ];
        Configure::write('debug', true);

        foreach (['qa', 'uat'] as $environment) {
            $sensorStatus = $this->createSensor([
                'environment' => $environment,
                'environments' => $environments,
            ])->getSensorStatus();

            $this->assertFalse($sensorStatus->status, sprintf('Environment "%s" must be ignored.', $environment));
        }

        $this->assertTrue($this->createSensor([
            'environment' => 'local',
            'environments' => $environments,
        ])->getSensorStatus()->status);
    }

    /**
     * An empty map of environments expects the debug mode to be disabled everywhere.
     *
     * @return void
     * @covers ::getEnvironmentExpectations
     */
    public function testEmptyEnvironmentsExpectDebugModeDisabled(): void
    {
        Configure::write('debug', false);

        $sensorStatus = $this->createSensor([
            'environment' => 'development',
            'environments' => [],
        ])->getSensorStatus();

        $this->assertTrue($sensorStatus->status);
    }
}
