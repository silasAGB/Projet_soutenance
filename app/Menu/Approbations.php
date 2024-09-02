<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Approbations implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Approbations', [
            'permission' => 'backend',
            'active' => 'boilerplate.approbations',
            'icon' => 'fa fa-check-square',
            'order' => 1,
        ]);

        $item->add('Apprbations', [
            'permission' => 'backend',
            'active' => 'boilerplate.approbations.gerer',
            'route' => 'boilerplate.approbations.gerer',
        ]);

    }
}
