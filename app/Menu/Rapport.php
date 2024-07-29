<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Rapport implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Rapport', [
            'permission' => 'backend',
            'active' => 'boilerplate.rapport.index',
            'icon' => 'fa fa-pie-chart',
            'route' => 'boilerplate.rapport.index',
            'order' => 6,
        ]);

    }
}
