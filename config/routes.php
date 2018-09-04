<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'OrcaServices/Heartbeat',
    ['path' => '/heartbeat'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::extensions(['json']);
Router::connect('/heartbeat', [
    'plugin' => 'OrcaServices/Heartbeat',
    'controller' => 'Heartbeat',
    'action' => 'index',
]);
