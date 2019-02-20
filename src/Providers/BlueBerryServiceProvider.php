<?php

namespace BlueBerry\Providers;

use Plenty\Plugin\ServiceProvider;
// use BlueBerry\BlueBerryRouteServiceProvider;

class BlueBerryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     */

    public function register() {
        $this->getApplication()->register(BlueBerryRouteServiceProvider::class);
    }
}