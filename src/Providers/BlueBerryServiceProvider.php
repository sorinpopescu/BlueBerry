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
use Plenty\Modules\Webshop\Template\Providers\TemplateServiceProvider;
use BlueBerry\Providers\BlueBerryRouteServiceProvider;
use Plenty\Plugin\Templates\Twig;

class BlueBerryServiceProvider extends ServiceProvider {

    const EVENT_LISTENER_PRIORITY = 0;

    /**
     * Register the service provider.
     */
    public function register()
    {
        // Register routes
        // $this->getApplication()->register( BlueBerryRouteServiceProvider::class );
    }

    /**
     * Register event listeners for IO events.
     * @param $event
     * @param $listener
     */
    private function listenToIO($event, $dispatcher, $listener, $priority = 0)
    {
        $priority = ($priority > 0 ? $priority : self::EVENT_LISTENER_PRIORITY);
        $dispatcher->listen('IO.' . $event, $listener, $priority);
        $dispatcher->listen('IO.intl.' . $event, $listener, $priority);
    }

    /**
     * Boot method check if user is logged in or not and redirect him
     */
    public function boot(Twig $twig, Dispatcher $eventDispatcher)
    {

        $this->listenToIO("Resources.Import", $eventDispatcher, function(ResourceContainer $container) {
            $container->addScriptTemplate('BlueBerry::ItemList.Components.CategoryItem');
            // $container->addScriptTemplate('BlueBerry::Item.Components.SingleItem');
            //$container->addScriptTemplate('BlueBerry::Item.Components.ItemPrice');
        });

        $this->listenToIO('tpl.item', $eventDispatcher, function (TemplateContainer $container) {
            $container->setTemplate('BlueBerry::Item.SingleItemWrapper');
            return false;
        });

        $this->listenToIO('tpl.category.item', $eventDispatcher, function (TemplateContainer $container) {
            $container->setTemplate('BlueBerry::Category.Item.CategoryItem');
            return false;
        });

        $this->listenToIO('tpl.search', $eventDispatcher, function (TemplateContainer $container) {
            $container->setTemplate('BlueBerry::Category.Item.CategoryItem');
            return false;
        });

        $this->listenToIO('tpl.my-account', $eventDispatcher, function (TemplateContainer $container) {
            $container->setTemplate('BlueBerry::MyAccount.MyAccountView');
            return false;
        });

        $this->listenToIO('init.templates', $eventDispatcher, function (Partial $partial) {
            $partial->set('header', 'BlueBerry::PageDesign.Partials.Header.Header');
            $partial->set('page-design', 'BlueBerry::PageDesign.PageDesign');
        });
    }

    /**
     * redirect to destination
     */
    public function redirectTo($path) {
        header("Location: " . $path);
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
                $this->redirectTo('/' . $sessionLanguage.'/customer-login');
            } elseif ($isRest === false && stripos($currentUri, 'customer-') !== false) {
                // set my login design
                $this->listenToIO('init.templates', $eventDispatcher, function (Partial $partial) use ($currentUri) {
                    // the partial
                    $partial->set('page-design-login', 'BlueBerry::PageDesign.PageDesignLogin');
                    // The login
                    $partial->set('pageDesignType', (stripos($currentUri, 'customer-register') !== false ? 'register' : 'login'));
                    // return data
                    return false;
                }, 800);
            };
        // IF user is loggedin and still on this page - redirect him
        } elseif (stripos($currentUri, 'customer-') !== false) {
            $this->redirectTo('/' . $sessionLanguage . '/');
        };
    }

    /**
     * Set default design
     */
    public function wait_setDesign() {}
}
