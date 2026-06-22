<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestCase\Heartbeat;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use OrcaServices\Heartbeat\Heartbeat\Heartbeat;

class HeartbeatTests extends TestCase
{
    /**
     * When an environment is configured, it is appended to the name in the system status title.
     *
     * @return void
     * @covers ::getSystemStatus
     */
    public function testGetSystemStatusAppendsEnvironment()
    {
        Configure::write('App.Heartbeat.name', 'My App');
        Configure::write('App.Heartbeat.environment', 'Production');

        $systemStatus = (new Heartbeat())->check()->getSystemStatus();

        $this->assertSame('My App Production Heartbeat Status', $systemStatus->name);
    }

    /**
     * When no environment is configured, only the name is used in the system status title.
     *
     * @return void
     * @covers ::getSystemStatus
     */
    public function testGetSystemStatusWithoutEnvironment()
    {
        Configure::write('App.Heartbeat.name', 'My App');
        Configure::delete('App.Heartbeat.environment');

        $systemStatus = (new Heartbeat())->check()->getSystemStatus();

        $this->assertSame('My App Heartbeat Status', $systemStatus->name);
    }

    /**
     * An empty environment is treated as if it were not configured at all.
     *
     * @return void
     * @covers ::getSystemStatus
     */
    public function testGetSystemStatusWithEmptyEnvironment()
    {
        Configure::write('App.Heartbeat.name', 'My App');
        Configure::write('App.Heartbeat.environment', '');

        $systemStatus = (new Heartbeat())->check()->getSystemStatus();

        $this->assertSame('My App Heartbeat Status', $systemStatus->name);
    }
}
