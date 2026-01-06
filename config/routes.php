<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

return static function (RouteBuilder $routes) {
    $routes->plugin(
        'OrcaServices/Heartbeat',
        ['path' => '/heartbeat'],
        function (RouteBuilder $routes) {
            $routes->fallbacks(DashedRoute::class);
        }
    );
    $routes->setExtensions(['json']);
    $routes->connect('/heartbeat', [
        'plugin' => 'OrcaServices/Heartbeat',
        'controller' => 'Heartbeat',
        'action' => 'index',
    ]);
};
