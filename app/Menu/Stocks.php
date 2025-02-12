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
            'order' => '5'

        ]);

        $item->add('Catégorie', [
            'permission' => 'backend',
            'active' => ['boilerplate.categories.index','boilerplate.categories.create','boilerplate.categories.edit'],
            'route' => 'boilerplate.categories.index',
        ]);

        $item->add('Matières premières', [
            'permission' => 'backend',
            'active' => ['boilerplate.matierepremieres.index','boilerplate.matierepremieres.mouvements','boilerplate.matierepremieres.create','boilerplate.matierepremieres.edit'],
            'route' => 'boilerplate.matierepremieres.index',
        ]);

    }
}
