<?php

namespace App\Datatables;

use App\Models\MatierePremiere;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class MatierepremieresDatatable extends Datatable
{
    public $slug = 'matierepremieres';

    public function datasource()
    {
        return MatierePremiere::with('categorie')->select('matiere_premieres.*');
    }

    public function setUp()
    {
        $this->order('id', 'asc');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Nom'))
                ->data('nom_MP'),

            Column::add(__('Unite'))
                ->data('unite'),

            Column::add(__('Qte Stock'))
                ->data('qte_stock'),

            Column::add(__('Stock Min'))
                ->data('stock_min'),

            Column::add(__('Emplacement'))
                ->data('emplacement'),


            Column::add()
                ->width('20px')
                ->actions(function (MatierePremiere $matierepremiere) {
                    return join([
                        Button::edit('boilerplate.matierepremieres.edit', $matierepremiere->id_MP),
                        Button::delete('boilerplate.matierepremieres.destroy', $matierepremiere->id_MP),
                    ]);
                }),
        ];
    }
}
