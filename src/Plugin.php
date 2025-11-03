<?php

namespace OrcaServices\Heartbeat;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;

/**
 * CakePHP Heartbeat Plugin
 */
class Plugin extends BasePlugin
{
    /**
     * {@inheritdoc}
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        // Add middleware here.
        return $middlewareQueue;
    }

    /**
     * {@inheritdoc}
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        // Add console commands here.
        return $commands;
    }

    /**
     * {@inheritdoc}
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        // Add constants, load configuration defaults.
        // By default will load `config/bootstrap.php` in the plugin.
        parent::bootstrap($app);
    }

    /**
     * {@inheritdoc}
     */
    public function routes(RouteBuilder $routes): void
    {
        // Add routes.
        // By default will load `config/routes.php` in the plugin.
        parent::routes($routes);
    }
}
