<?php //strict

namespace BlueBerry\Services;

use Plenty\Modules\Frontend\Services\AccountService;

class BlueBerryCustomerService {

    private $accountService;

    public function __construct(AccountService $accountService) {
        $this->accountService = $accountService;
        return $accountService;
    }

    public function isLoggedIn() {
        return $this->accountService->getIsAccountLoggedIn();
    }
};