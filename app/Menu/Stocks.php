<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Stocks implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Stocks', [
            'permission' => 'backend',
            'active' => 'boilerplate.stocks.*',
            'icon' => 'fa fa-archive',
            'order' => '4'

        ]);

        $item->add('Catégorie', [
            'permission' => 'backend',
            'active' => 'boilerplate.categories.index',
            'route' => 'boilerplate.categories.index',
        ]);

        $item->add('Matieres premiers', [
            'permission' => 'backend',
            'active' => 'boilerplate.matierepremieres.index',
            'route' => 'boilerplate.matierepremieres.index',
        ]);

        $item->add('Produits', [
            'permission' => 'backend',
            'active' => 'boilerplate.produits.index',
            'route' => 'boilerplate.produits.index',
        ]);

    }
}
