<?php
declare(strict_types=1);

namespace OrcaServices\Heartbeat\Test\TestApp;

use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\RouteBuilder;
use OrcaServices\Heartbeat\Plugin as HeartbeatPlugin;

/**
 * Minimal test application used by integration tests.
 *
 * It loads only the Heartbeat plugin and the routing middleware so that
 * HeartbeatControllerTest can boot a real HTTP stack without requiring a
 * full CakePHP application skeleton.
 */
class TestApplication extends BaseApplication
{
    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        $this->addPlugin(HeartbeatPlugin::class);
    }

    /**
     * @inheritDoc
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue->add(new RoutingMiddleware($this));

        return $middlewareQueue;
    }

    /**
     * @inheritDoc
     */
    public function routes(RouteBuilder $routes): void
    {
        $pluginRoutes = require dirname(__DIR__, 2) . '/config/routes.php';
        $pluginRoutes($routes);
    }
}
