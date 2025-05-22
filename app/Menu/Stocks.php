<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Stocks implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Stocks', [
            'permission' => 'voir_matiere_premieres',
            'active' => 'boilerplate.stocks.*',
            'icon' => 'fa fa-archive',
            'order' => '5'

        ]);

        $item->add('Catégorie', [
            'permission' => 'voir_matiere_premieres',
            'active' => ['boilerplate.categories.index','boilerplate.categories.create','boilerplate.categories.edit'],
            'route' => 'boilerplate.categories.index',
        ]);

        $item->add('Matières premières', [
            'permission' => 'voir_matiere_premieres',
            'active' => ['boilerplate.matierepremieres.index','boilerplate.matierepremieres.mouvements','boilerplate.matierepremieres.create','boilerplate.matierepremieres.edit'],
            'route' => 'boilerplate.matierepremieres.index',
        ]);

    }
}
