<?php

namespace BlueBerry\Providers;

use IO\Helper\UserSession;
use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use IO\Extensions\Functions\Partial;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use BlueBerry\Providers\BlueBerryRouteServiceProvider;
use Plenty\Plugin\Templates\Twig;

class BlueBerryServiceProvider extends ServiceProvider {

    private static $templateKeyToViewMap =
    [
        'tpl.home'                          => ['Homepage.Homepage',                      GlobalContext::class],
        'tpl.home.category'                 => ['Homepage.HomepageCategory',              CategoryContext::class],
        'tpl.category.content'              => ['Category.Content.CategoryContent',       CategoryContext::class],
        'tpl.category.item'                 => ['Category.Item.CategoryItem',             CategoryItemContext::class],
        'tpl.category.blog'                 => ['PageDesign.PageDesign',                  GlobalContext::class],
        'tpl.category.container'            => ['PageDesign.PageDesign',                  GlobalContext::class],
        'tpl.item'                          => ['Item.SingleItemWrapper',                 SingleItemContext::class],
        'tpl.basket'                        => ['Basket.Basket',                          GlobalContext::class],
        'tpl.checkout'                      => ['Checkout.CheckoutView',                  CheckoutContext::class],
        'tpl.checkout.category'             => ['Checkout.CheckoutCategory',              CheckoutContext::class],
        'tpl.my-account'                    => ['MyAccount.MyAccountView',                GlobalContext::class],
        'tpl.my-account.category'           => ['MyAccount.MyAccountCategory',            CategoryContext::class],
        'tpl.confirmation'                  => ['Checkout.OrderConfirmation',             OrderConfirmationContext::class],
        'tpl.login'                         => ['Customer.Login',                         GlobalContext::class],
        'tpl.register'                      => ['Customer.Register',                      GlobalContext::class],
        'tpl.guest'                         => ['Customer.Guest',                         GlobalContext::class],
        'tpl.password-reset'                => ['Customer.ResetPassword',                 PasswordResetContext::class],
        'tpl.change-mail'                   => ['Customer.ChangeMail',                    ChangeMailContext::class],
        'tpl.contact'                       => ['Customer.Contact',                       GlobalContext::class],
        'tpl.search'                        => ['Category.Item.CategoryItem',             ItemSearchContext::class],
        'tpl.wish-list'                     => ['WishList.WishListView',                  GlobalContext::class],
        'tpl.order.return'                  => ['OrderReturn.OrderReturnView',            OrderReturnContext::class],
        'tpl.order.return.confirmation'     => ['OrderReturn.OrderReturnConfirmation',    GlobalContext::class],
        'tpl.cancellation-rights'           => ['StaticPages.CancellationRights',         GlobalContext::class],
        'tpl.cancellation-form'             => ['StaticPages.CancellationForm',           GlobalContext::class],
        'tpl.legal-disclosure'              => ['StaticPages.LegalDisclosure',            GlobalContext::class],
        'tpl.privacy-policy'                => ['StaticPages.PrivacyPolicy',              GlobalContext::class],
        'tpl.terms-conditions'              => ['StaticPages.TermsAndConditions',         GlobalContext::class],
        'tpl.item-not-found'                => ['StaticPages.ItemNotFound',               GlobalContext::class],
        'tpl.page-not-found'                => ['StaticPages.PageNotFound',               GlobalContext::class],
        'tpl.newsletter.opt-out'            => ['Newsletter.NewsletterOptOut',            GlobalContext::class],
        'tpl.mail.contact'                  => ['Customer.Components.Contact.ContactMail',GlobalContext::class]
    ];

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
        // Redirect to a force login page - SKIP FOR NOW
        // $this->checkForceLogin($eventDispatcher);
        // Set BlueBerry Homepage
        // $this->setDesign();

        $eventDispatcher->listen('IO.init.templates', function(Partial $partial)
        {
           $partial->set('header', 'BlueBerry::PageDesign.Partials.Header.Header');
           return false;
        }, 0);


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
