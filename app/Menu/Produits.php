<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Produits implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Produits', [
            'permission' => 'backend',
            'active' => 'boilerplate.produits',
            'icon' => 'square',
            'order' => 1,
        ]);

      /*  $item->add('Statistiques', [
            'permission' => 'backend',
            'active' => 'boilerplate.produits.statistiques',
            'route' => 'boilerplate.dashboard',
        ]);

        */

        $item->add('Gestion de produits', [
            'permission' => 'backend',
            'active' => ['boilerplate.produits.index','boilerplate.produits.create','boilerplate.produits.details','boilerplate.produits.edit'],
            'route' => 'boilerplate.produits.index',
        ]);
    }
}
