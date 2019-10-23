<?php

namespace BlueBerry\Containers;

use Plenty\Plugin\Templates\Twig;

class BlueBerryContainer {
    public function call(Twig $twig):string
    {
        return $twig->render('BlueBerry::content.BlueBerry');
    }
}
