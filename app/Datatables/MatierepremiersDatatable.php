<?php

namespace App\Datatables;

use App\Models\MatierePremiere;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class MatierepremiersDatatable extends Datatable
{
    public $slug = 'matierepremiers';

    public function datasource()
    {
        return MatierePremiere::query();
    }

    public function setUp()
    {
        $this->order('id', 'asc');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Nom Mp'))
                ->data('nom_MP'),

            Column::add(__('Prix Achat en FCFA'))
                ->data('prix_achat'),

            Column::add(__('Unite'))
                ->data('unite'),

            Column::add(__('Qte Stock'))
                ->data('qte_stock'),

            Column::add(__('Stock Min'))
                ->data('stock_min'),

            Column::add(__('Emplacement'))
                ->data('emplacement'),

            Column::add(__('Id Categorie'))
                ->data('id_categorie'),

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
                ->actions(function (MatierePremiere $matierepremiere) {
                    return join([
                        // Button::show('matierepremiere.show', $matierepremiere),
                         Button::edit('boilerplate.matierepremieres.edit', $matierepremiere->id_MP),
                         Button::delete('boilerplate.matierepremieres.destroy', $matierepremiere->id_MP),
                    ]);
                }),
        ];
    }
}
