<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Commandes implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Commandes', [
            'permission' => 'backend',
            'active' => 'boilerplate.commande',
            'icon' => 'fa fa-shopping-cart',
            'order' => 5,
        ]);

        $item->add('Statistiques commandes', [
            'permission' => 'backend',
            'active' => 'boilerplate.commande.statistiques',
            'route' => 'boilerplate.commande.statistiques',
        ]);

        $item->add('Gerer commandes', [
            'permission' => 'backend',
            'active' => 'boilerplate.commande.gerer',
            'route' => 'boilerplate.commande.gerer',
        ]);
    }
}
