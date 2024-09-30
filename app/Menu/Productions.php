<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Productions implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Productions', [
            'permission' => 'backend',
            'active' => 'boilerplate.productions',
            'icon' => 'square',
            'order' => 3,
        ]);

        $item->add('Statistique productions', [
            'permission' => 'backend',
            'active' => 'boilerplate.productions.statistiques',
            'route' => 'boilerplate.productions.statistiques',
        ]);

        $item->add('Gerer Productions', [
            'permission' => 'backend',
            'active' => 'boilerplate.productions.gerer',
            'route' => 'boilerplate.productions.gerer',
        ]);
    }
}
