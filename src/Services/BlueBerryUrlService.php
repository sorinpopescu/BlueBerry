<?php //strict

namespace BlueBerry\Services;

use Plenty\Modules\Frontend\Services\UrlService;
use Plenty\Plugin\Routing\Router;

class BlueBerryUrlService {

    private $urlService;
    private $routeService;

    public function __construct(UrlService $urlService, Router $routeService) {
        $this->urlService = $urlService;
        $this->routeService = $routeService;
    }

    public function isLoggedIn() {
        return $this->urlService->getIsAccountLoggedIn();
    }

    public function getCurrentController() {
        die('x'.$this->urlService->getActionName());
    }
};