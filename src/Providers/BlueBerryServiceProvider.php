<?php

namespace BlueBerry\Providers;

use Plenty\Plugin\ServiceProvider;
use BlueBerry\Services\BlueBerryCustomerService;

class BlueBerryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     */

    public function register() {
        // Register routes
        // $this->getApplication()->register( BlueBerryRouteServiceProvider::class );
        // Register Our service
        $this->getApplication()->singleton( BlueBerryCustomerService::class );
    }

    public function boot() {
        $customerService = pluginApp(BlueBerryCustomerService::class);

        var_dump($customerService->isLoggedIn());

        die('sorin');
    }
}