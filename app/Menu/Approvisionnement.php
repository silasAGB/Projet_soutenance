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
            'order' => 4,
        ]);

        $item->add('Statistique Approvisionnements', [
            'permission' => 'backend',
            'active' => 'boilerplate.approvisionnements.statistiques',
            'route' => 'boilerplate.approvisionnements.statistiques',
        ]);

        $item->add('Gérer Approvisionnements', [
            'permission' => 'backend',
            'active' => ['boilerplate.approvisionnements.gerer','boilerplate.approvisionnements.create','boilerplate.approvisionnements.details','boilerplate.approvisionnements.edit'],
            'route' => 'boilerplate.approvisionnements.gerer',
        ]);

        $item->add('Gerer fournisseur', [
            'permission' => 'backend',
            'active' => ['boilerplate.approvisionnements.fournisseurs','boilerplate.approvisionnements.createfournisseur','boilerplate.fournisseur.edit'],
            'route' => 'boilerplate.approvisionnements.fournisseurs',
        ]);

    }




}



