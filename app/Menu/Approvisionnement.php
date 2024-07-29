<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Approvisionnement implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Approvisionnements', [
            'permission' => 'backend',
            'active' => 'boilerplate.approvisionnements',
            'icon' => 'fa fa-truck',
            'order' => 2,
        ]);

        $item->add('Statistique Approvisionnements', [
            'permission' => 'backend',
            'active' => 'boilerplate.approvisionnements.statistiques',
            'route' => 'boilerplate.approvisionnements.statistiques',
        ]);

        $item->add('Gerer Approvisionnements', [
            'permission' => 'backend',
            'active' => 'boilerplate.approvisionnements.gerer',
            'route' => 'boilerplate.approvisionnements.gerer',
        ]);

        $item->add('Gerer fournisseur', [
            'permission' => 'backend',
            'active' => 'boilerplate.approvisionnements.fournisseurs',
            'route' => 'boilerplate.approvisionnements.fournisseurs',
        ]);

    }




}



