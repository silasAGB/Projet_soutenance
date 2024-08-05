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
        return Production::with('produit')->select('productions.*');
    }

    public function setUp()
    {
        $this->order('id', 'asc');
        $this->buttons('filters', 'csv', 'refresh','print');
    }


    public function columns(): array
{
    return [

        Column::add(__('Date Prevue'))
            ->width('180px')
            ->data('date_prevue')
            ->dateFormat(__("boilerplate::date.Ymd")),

        Column::add(__('Qte Prevue'))
            ->data('qte_prevue'),

        Column::add(__('Qte Produite'))
            ->data('qte_produite'),

        Column::add(__('Date Production'))
            ->width('180px')
            ->data('date_production')
            ->dateFormat(__("boilerplate::date.Ymd")),

        Column::add(__('Montant Produit'))
            ->data('montant_produit'),

        Column::add(__('Statut'))
            ->data('statut'),

        Column::add(__('Produit'))
            ->data('produit.nom_Produit'),

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
