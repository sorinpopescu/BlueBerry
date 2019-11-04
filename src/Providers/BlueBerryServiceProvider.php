<?php

namespace BlueBerry\Providers;

use IO\Guards\AuthGuard;
use IO\Helper\UserSession;
use IO\Helper\TemplateContainer;
use IO\Helper\ComponentContainer;
use IO\Helper\ResourceContainer;
use IO\Extensions\Functions\Partial;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use BlueBerry\Providers\BlueBerryRouteServiceProvider;
use Plenty\Plugin\Templates\Twig;
use IO\Services\CustomerService;
use Plenty\Modules\ShopBuilder\Helper\ShopBuilderRequest;
use Plenty\Modules\Authentication\Events\AfterAccountAuthentication;

class BlueBerryServiceProvider extends ServiceProvider {

    const EVENT_LISTENER_PRIORITY = 100;
    /**
     * Register the service provider.
     */
    public function register() {
        // Register routes
        // $this->getApplication()->register( BlueBerryRouteServiceProvider::class );
    }

    /**
     * Boot method check if user is logged in or not and redirect him
     */
    public function boot(Twig $twig, Dispatcher $eventDispatcher) {

        // $guard = pluginApp(AuthGuard::class);
        // $guard->assertOrRedirect( true, '/login');
        $eventDispatcher->listen('IO.Component.Import', function (ComponentContainer $container)
        {
            if ($container->getOriginComponentTemplate()=='Ceres::Item.Components.SingleItem')
            {
                $container->setNewComponentTemplate('BlueBerry::Item.Components.SingleItem');
            }
            if ($container->getOriginComponentTemplate()=='Ceres::ItemList.Components.CategoryItem')
            {
                $container->setNewComponentTemplate('BlueBerry::ItemList.Components.CategoryItem');
            }
        }, 0);

        $dispatcher->listen(AfterAccountAuthentication::class, function($event)
        {
            $eventDispatcher->listen('IO.init.templates', function(Partial $partial)
            {
            $partial->set('footer', 'BlueBerry::PageDesign.Partial.Footer');
            }, 0);
        });
        //$shopBuilderRequest = pluginApp(ShopBuilderRequest::class);
        /*if($customerService->getContactId() > 0)
        {
                $eventDispatcher->listen('IO.init.templates', function(Partial $partial)
            {
            $partial->set('footer', 'BlueBerry::PageDesign.Partial.Footer');
            }, 0);
            //return false;
        };*/
    }

    /**
     * redirect to destination
     */
    public function redirectTo($path) {
        header("Location: ".$path);
        die;
    }

    /**
     * Redirect to login
     */
    public function checkForceLogin(Dispatcher $eventDispatcher) {
        // // Get the service data
        $currentUri = trim(!empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : (!empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null));
        // What language
        $sessionLanguage = null;
        if (stripos($currentUri, '/en/') !== false || $currentUri === '/en') {
            $sessionLanguage = 'en';
        } else {
            $sessionLanguage = 'de';
        };
        // Check if user is logged in
        $userIsLoggedIn = pluginApp(UserSession::class)->isContactLoggedIn();
        // Check if it's not login
        if (!$userIsLoggedIn) {
            // Is rest
            $isRest = stripos($currentUri, 'rest/');
            // if there is no rest or
            if ($isRest === false && stripos($currentUri, 'customer-') === false) {
                // Redirect to login
                $this->redirectTo('/'.$sessionLanguage.'/customer-login');
            } else if ($isRest === false && stripos($currentUri, 'customer-') !== false) {
                // set my login design
                $eventDispatcher->listen('IO.init.templates', function (Partial $partial) use ($currentUri) {
                    // the partial
                    $partial->set('page-design-login', 'BlueBerry::PageDesign.PageDesignLogin');
                    // The login
                    $partial->set('pageDesignType', (stripos($currentUri, 'customer-register') !== false ? 'register' : 'login'));
                    // return data
                    return false;
                }, 800);
            };
        // IF user is loggedin and still on this page - redirect him
        } else if (stripos($currentUri, 'customer-') !== false) {
            $this->redirectTo('/'.$sessionLanguage.'/');
        };
    }

    /**
     * Set default design
     */
    public function setDesign() {

    }
}
