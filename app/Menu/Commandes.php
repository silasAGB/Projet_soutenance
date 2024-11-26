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
            'active' => 'boilerplate.commandes',
            'icon' => 'fa fa-shopping-cart',
            'order' => 2,
        ]);

        $item->add('Statistiques commandes', [
            'permission' => 'backend',
            'active' => 'boilerplate.commandes.statistiques',
            'route' => 'boilerplate.commandes.statistiques',
        ]);

        $item->add('Gerer commandes', [
            'permission' => 'backend',
            'active' => 'boilerplate.commandes.gerer',
            'route' => 'boilerplate.commandes.gerer',
        ]);

        $item->add('Client', [
            'permission' => 'backend',
            'active' => 'boilerplate.commandes.client',
            'route' => 'boilerplate.commandes.client',
        ]);
    }
}
