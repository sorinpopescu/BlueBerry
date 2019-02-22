<?php

namespace BlueBerry\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;

class ContentController extends Controller {

    public function doLogin(Twig $twig) {
        return $twig->render('BlueBerry::content.login');
    }

    public function doRegister(Twig $twig) {
        return $twig->render('BlueBerry::content.register');
    }
}