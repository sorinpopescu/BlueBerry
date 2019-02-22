<?php //strict

namespace BlueBerry\Services;

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
