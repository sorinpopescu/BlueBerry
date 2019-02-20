<?php

namespace BlueBerry\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

class BlueBerryRouteServiceProvider extends RouteServiceProvider {

    public function map(Router $router) {
        $router->get('sorin','BlueBerry\Controllers\ContentController@sayHello');
    }
}