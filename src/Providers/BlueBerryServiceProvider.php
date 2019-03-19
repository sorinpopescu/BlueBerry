<?php

namespace BlueBerry\Providers;

use IO\Extensions\Functions\Partial;
use Plenty\Plugin\ServiceProvider;
use Plenty\Modules\Frontend\Services\AccountService;
use Plenty\Plugin\Events\Dispatcher;

class BlueBerryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     */

    public function register() {
        // Register routes
        $this->getApplication()->register( BlueBerryRouteServiceProvider::class );
    }

    public function boot(Dispatcher $eventDispatcher) {
        // // Get the service data
        $customerService = pluginApp(AccountService::class);
        // $currentUri = trim(!empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : (!empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null));
        // // What language
        // $sessionLanguage = null;
        // if (stripos($currentUri, '/en/') !== false || $currentUri === '/en') {
        //     $sessionLanguage = 'en';
        // } else {
        //     $sessionLanguage = 'de';
        // };
        // // Check if it's not login
        // if (!$customerService->getIsAccountLoggedIn()) {
        //     // Is rest
        //     $isRest = stripos($currentUri, 'rest/');
        //     // if there is no rest or
        //     if ($isRest === false && stripos($currentUri, 'customer-') === false) {
        //         // Redirect to login
        //         //$urlService->redirectTo('/'.$sessionLanguage.'/customer-login');
        //     } else if ($isRest === false && stripos($currentUri, 'customer-') !== false) {
        //         // set my login design
        //         $eventDispatcher->listen('IO.init.templates', function (Partial $partial) use ($currentUri) {
        //             // the partial
        //             $partial->set('page-design-login', 'BlueBerry::PageDesign.PageDesignLogin');
        //             // The login
        //             $partial->set('pageDesignType', (stripos($currentUri, 'customer-register') !== false ? 'register' : 'login'));
        //             // return data
        //             return false;
        //         }, 800);
        //     };
        // // IF user is loggedin and still on this page - redirect him
        // } else if (stripos($currentUri, 'customer-') !== false) {
        //     //$urlService->redirectTo('/'.$sessionLanguage.'/');
        // };
    }
}
