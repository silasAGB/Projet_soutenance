<?php

namespace App\Datatables;

use App\Models\Categorie;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class CategoriesDatatable extends Datatable
{
    public $slug = 'categories';

    public function datasource()
    {
        return Categorie::query();
    }

    public function setUp()
    {
        $this->stateSave();
    }

    public function columns(): array
    {
        return [


            Column::add(__('Code Categorie'))
                ->data('code_Categorie'),

            Column::add(__('Nom Categorie'))
                ->data('nom_Categorie'),

            Column::add(__('Created At'))
                ->width('180px')
                ->data('created_at')
                ->dateFormat(),

            Column::add(__('Updated At'))
                ->width('180px')
                ->data('updated_at')
                ->dateFormat(),

            Column::add()
                ->width('20px')
                ->actions(function (Categorie $categorie) {
                    return join([
                        Button::edit('boilerplate.categories.edit', $categorie),
                        Button::delete('boilerplate.categories.destroy', $categorie),
                    ]);
                }),
        ];
    }
}
