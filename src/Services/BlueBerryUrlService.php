<?php //strict

namespace BlueBerry\Services;

//use IO\Services\UrlService;
//use Plenty\Plugin\Routing\Route;
use Plenty\Plugin\Http\Request;

class BlueBerryUrlService {

    //private $urlService;
    private $requestService;

    public function __construct(Request $requestService) {
        $this->requestService = $requestService;
    }

    public function getCurrentUri() {
        return $this->requestService->getRequestUri();
    }
};
