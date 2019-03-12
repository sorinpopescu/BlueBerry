<?php

namespace BlueBerry\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

class BlueBerryRouteServiceProvider extends RouteServiceProvider {

    public function map(Router $router) {
        // Login action
        $router->get('customer-login','BlueBerry\Controllers\ContentController@doLogin');
        $router->get('de/customer-login','BlueBerry\Controllers\ContentController@doLogin');
        $router->get('en/customer-login','BlueBerry\Controllers\ContentController@doLogin');
        $router->get('gb/customer-login','BlueBerry\Controllers\ContentController@doLogin');
        // Register action
        $router->get('customer-register','BlueBerry\Controllers\ContentController@doRegister');
        $router->get('de/customer-register','BlueBerry\Controllers\ContentController@doRegister');
        $router->get('en/customer-register','BlueBerry\Controllers\ContentController@doRegister');
        $router->get('gb/customer-register','BlueBerry\Controllers\ContentController@doRegister');
    }
}