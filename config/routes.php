<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

return static function (RouteBuilder $routes) {
    $routes->plugin(
        'OrcaServices/Heartbeat',
        ['path' => '/heartbeat'],
        function (RouteBuilder $routes) {
            $routes->fallbacks(DashedRoute::class);
        }
    );
    Router::extensions(['json']);
    $routes->connect('/heartbeat', [
        'plugin' => 'OrcaServices/Heartbeat',
        'controller' => 'Heartbeat',
        'action' => 'index',
    ]);
};
