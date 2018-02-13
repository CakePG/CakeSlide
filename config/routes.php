<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::prefix('admin', function ($routes) {
  $routes->plugin('CakePG/CakeSlide', ['path' => '/cakeslide'], function ($routes) {
    $routes->fallbacks(DashedRoute::class);
  });
});
