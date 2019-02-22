<?php

namespace BlueBerry\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

class BlueBerryRouteServiceProvider extends RouteServiceProvider {

    public function map(Router $router) {
        // Login action
        $router->get('customer-login','BlueBerry\Controllers\ContentController@doLogin');
        // Register action
        $router->get('customer-register','BlueBerry\Controllers\ContentController@register');
    }
}