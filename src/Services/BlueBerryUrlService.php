<?php //strict

namespace BlueBerry\Services;

use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;

class BlueBerryUrlService {

    private $requestService;
    private $responseService;

    public function __construct(Request $requestService, Response $responseService) {
        $this->requestService = $requestService;
        $this->responseService = $responseService;
    }

    public function getCurrentUri() {
        return $this->requestService->getRequestUri();
    }

    public function redirectTo($path) {
        return $this->responseService->redirectTo($path);
        // exit;die;
    }
};
