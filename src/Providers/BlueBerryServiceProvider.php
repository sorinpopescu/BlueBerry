<?php

namespace BlueBerry\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Modules\Frontend\Services\AccountService;
use Plenty\Plugin\Events\Dispatcher;
use IO\Extensions\Functions\Partial;
use Plenty\Plugin\Http\Request;
//use Plenty\Plugin\Http\Response;
//use BlueBerry\Services\BlueBerryCustomerService;
//use BlueBerry\Services\BlueBerryUrlService;

class BlueBerryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     */

    public function register() {
        // Register routes
        $this->getApplication()->register( BlueBerryRouteServiceProvider::class );
        // Register Our service
        // $this->getApplication()->singleton( BlueBerryCustomerService::class );
        // $this->getApplication()->singleton( BlueBerryUrlService::class );
    }

    public function boot(AccountService $accountService, Request $requestService, Dispatcher $eventDispatcher) {
        // Get the service data
        //$customerService = pluginApp(BlueBerryCustomerService::class);
        // $urlService = pluginApp(BlueBerryUrlService::class);
        $currentUri = $requestService->getRequestUri();
        // What language
        $sessionLanguage = null;
        if (stripos($currentUri, '/en/') !== false || $currentUri === '/en') {
            $sessionLanguage = 'en';
        } else {
            $sessionLanguage = 'de';
        };
        // Check if it's not login
        if (!$accountService->getIsAccountLoggedIn()) {
            // Is rest
            $isRest = stripos($currentUri, 'rest/');
            // if there is no rest or
            if ($isRest === false && stripos($currentUri, 'customer-') === false) {
                // Redirect to login
                // $urlService->redirectTo('/'.$sessionLanguage.'/customer-login');
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
            // $urlService->redirectTo('/'.$sessionLanguage.'/');
        };
    }

    // Main redirector
    public function redirectTo($path) {
        header("Location: ".$path);
        die;
    }
}
