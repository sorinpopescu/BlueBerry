<?php //strict

namespace BlueBerry\Services;

//use IO\Services\UrlService;
//use Plenty\Plugin\Routing\Route;
use Plenty\Plugin\Http\Request;

class BlueBerryUrlService {

    //private $urlService;
    private $requestService;

    public function __construct(Request $requestService) {//UrlService $urlService,Route $routeService
        //$this->urlService = $urlService;
        $this->$requestService = $requestService;
    }

    public function getCurrentController() {
        die('x'.$this->$requestService->getRequestUri());
    }
};
