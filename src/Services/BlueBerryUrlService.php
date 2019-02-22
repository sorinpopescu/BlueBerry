<?php //strict

namespace BlueBerry\Services;

//use IO\Services\UrlService;
//use Plenty\Plugin\Routing\Route;
use Illuminate\Routing\Route as rootRoute;

class BlueBerryUrlService {

    //private $urlService;
    private $routeService;

    public function __construct() {//UrlService $urlService,Route $routeService
        //$this->urlService = $urlService;
        //$this->routeService = $routeService;
    }

    public function getCurrentController() {
        die('x'.rootRoute::getCurrentRoute()->getActionName());
    }
};
