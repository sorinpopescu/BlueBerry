<?php //strict

namespace BlueBerry\Services;

//use IO\Services\UrlService;
//use Plenty\Plugin\Routing\Route;
use Illuminate\Routing\Route;

class BlueBerryUrlService {

    //private $urlService;
    private $routeService;

    public function __construct(Route $routeService) {//UrlService $urlService,
        //$this->urlService = $urlService;
        //$this->routeService = $routeService;
    }

    public function getCurrentController() {
        die('x'.Route::getCurrentRoute()->getActionName());
    }
};
