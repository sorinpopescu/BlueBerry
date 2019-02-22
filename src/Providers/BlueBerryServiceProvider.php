<?php

namespace BlueBerry\Providers;

use Plenty\Plugin\ServiceProvider;
use BlueBerry\Services\BlueBerryCustomerService;
use BlueBerry\Services\BlueBerryUrlService;

class BlueBerryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     */

    public function register() {
        // Register routes
        // $this->getApplication()->register( BlueBerryRouteServiceProvider::class );
        // Register Our service
        $this->getApplication()->singleton( BlueBerryCustomerService::class );
        $this->getApplication()->singleton( BlueBerryUrlService::class );
    }

    public function boot() {
        // Get the service data
        $urlService = pluginApp(BlueBerryUrlService::class);
        $customerService = pluginApp(BlueBerryCustomerService::class);
        
        if (!$customerService->isLoggedIn()) {
            $currentUri = $urlService->getCurrentUri();
            // if there is no rest or 
            if (stripos($currentUri, 'rest/') === false && stripos($currentUri, 'account/') === false) {
                echo $currentUri;
            };
        };
    }
}
