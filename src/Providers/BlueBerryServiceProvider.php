<?php

namespace BlueBerry\Providers;

use Plenty\Plugin\ServiceProvider;
use BlueBerry\Services\BlueBerryCustomerService;
use BlueBerry\Services\BlueBerryUrlService;
use Plenty\Plugin\Events\Dispatcher;
use IO\Extensions\Functions\Partial;
use IO\Services\SessionStorageService;
use IO\Services\WebstoreConfigurationService;

class BlueBerryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     */

    public function register() {
        // Register routes
        $this->getApplication()->register( BlueBerryRouteServiceProvider::class );
        // Register Our service
        $this->getApplication()->singleton( BlueBerryCustomerService::class );
        $this->getApplication()->singleton( BlueBerryUrlService::class );
    }

    public function boot(Dispatcher $eventDispatcher) {
        // Get the service data
        $customerService = pluginApp(BlueBerryCustomerService::class);
        $urlService = pluginApp(BlueBerryUrlService::class);
        $currentUri = $urlService->getCurrentUri();
        $sessionStorageService = pluginApp(SessionStorageService::class);
        $sessionLanguage = $sessionStorageService->getLang();
        if (empty($sessionLanguage)) {
            $webstoreConfigService = pluginApp(WebstoreConfigurationService::class);
            $sessionLanguage = $webstoreConfigService->getDefaultLanguage();
            // Make sure we have it
            if (empty($sessionLanguage)) {
                $sessionLanguage = 'de';
            };
        };
        die('x'.$sessionLanguage);
        // Check if it's not login
        if (!$customerService->isLoggedIn()) {
            // Is rest
            $isRest = stripos($currentUri, 'rest/');
            // if there is no rest or
            if ($isRest === false && stripos($currentUri, 'customer-') === false) {
                // Redirect to login
                $urlService->redirectTo('/'.$sessionLanguage.'/customer-login');
            } else if ($isRest === false && stripos($currentUri, 'customer-') !== false) {
                // set my login design
                $eventDispatcher->listen('IO.init.templates', function (Partial $partial, $currentUri) {
                    // the partial
                    $partial->set('page-design-login', 'BlueBerry::PageDesign.PageDesignLogin');
                    // The login
                    $partial->set('pageDesignType', (stripos($currentUri, 'customer-register') !== false ? 'register' : 'login'));
                }, 100);
            };
        // IF user is loggedin and still on this page - redirect him
        } else if (stripos($currentUri, 'customer-') !== false) {
            $urlService->redirectTo('/'.$sessionLanguage.'/');
        };
    }
}
