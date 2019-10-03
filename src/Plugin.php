<?php

namespace OrcaServices\Heartbeat;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;

class Plugin extends BasePlugin
{
    /**
     * {@inheritdoc}
     */
    public function middleware($middleware)
    {
        // Add middleware here.
        return $middleware;
    }

    /**
     * {@inheritdoc}
     */
    public function console($commands)
    {
        // Add console commands here.
        return $commands;
    }

    /**
     * {@inheritdoc}
     */
    public function bootstrap(PluginApplicationInterface $app)
    {
        // Add constants, load configuration defaults.
        // By default will load `config/bootstrap.php` in the plugin.
        parent::bootstrap($app);
    }

    /**
     * {@inheritdoc}
     */
    public function routes($routes)
    {
        // Add routes.
        // By default will load `config/routes.php` in the plugin.
        parent::routes($routes);
    }
}
