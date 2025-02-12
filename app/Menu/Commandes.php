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

        $item->add('Gérer commandes', [
            'permission' => 'backend',
            'active' => ['boilerplate.commandes.gerer','boilerplate.commandes.create','boilerplate.commandes.details','boilerplate.commandes.edit'],
            'route' => 'boilerplate.commandes.gerer',
        ]);

        $item->add('Client', [
            'permission' => 'backend',
            'active' => ['boilerplate.commandes.client','boilerplate.commandes.createclient'],
            'route' => 'boilerplate.commandes.client',
        ]);
    }
}
