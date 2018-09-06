<?php

namespace OrcaServices\Heartbeat;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;

class Plugin extends BasePlugin
{
    public function middleware($middleware)
    {
        // Add middleware here.
        return $middleware;
    }

    public function console($commands)
    {
        // Add console commands here.
        return $commands;
    }

    public function bootstrap(PluginApplicationInterface $app)
    {
        // Add constants, load configuration defaults.
        // By default will load `config/bootstrap.php` in the plugin.
        parent::bootstrap($app);
    }

    public function routes($routes)
    {
        // Add routes.
        // By default will load `config/routes.php` in the plugin.
        parent::routes($routes);
    }
}
