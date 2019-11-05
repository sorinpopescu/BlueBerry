<?php

namespace BlueBerry\Containers;

use Plenty\Plugin\Templates\Twig;

class BlueBerryItemListContainer1
{
    public function call(Twig $twig, $arg):string
    {
        return $twig->render('BlueBerry::Containers.ItemLists.ItemList1', ["item" => $arg[0]]);
    }
}