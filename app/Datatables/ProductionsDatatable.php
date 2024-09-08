<?php

namespace App\Datatables;

use App\Models\Production;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class ProductionsDatatable extends Datatable
{
    public $slug = 'productions';

    public function datasource()
    {
        return Production::with('produit:id_produit,nom_produit')->select('productions.*');
    }

    public function setUp()
    {
        $this->order('id_production', 'asc');
        $this->buttons('filters', 'csv', 'refresh', 'print');
    }

    public function columns(): array
    {
        return [
            Column::add(__('Référence'))
                ->data('reference_production'),

            Column::add(__('Date Prévue'))
                ->width('180px')
                ->data('date_prevue')
                ->dateFormat(__("boilerplate::date.Ymd")),

            Column::add(__('Nombre de Préparations'))
                ->data('nbr_preparation'),

            Column::add(__('Quantité Produite'))
                ->data('qte_produite'),

            Column::add(__('Date de Production'))
                ->width('180px')
                ->data('date_production')
                ->dateFormat(__("boilerplate::date.Ymd")),

            Column::add(__('Statut'))
                ->data('statut'),

            Column::add(__('Produit'))
            ->data('produit.nom_produit'),

            Column::add()
                ->width('20px')
                ->actions(function (Production $production) {
                    return join([
                        Button::show('boilerplate.productions.show', $production),
                        Button::edit('boilerplate.productions.edit', $production),
                        Button::delete('boilerplate.productions.destroy', $production),
                    ]);
                }),
        ];
    }
}
