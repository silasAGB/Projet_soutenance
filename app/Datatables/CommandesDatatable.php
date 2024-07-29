<?php

namespace App\Datatables;

use App\Models\Commande;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class CommandesDatatable extends Datatable
{
    public $slug = 'commandes';

    public function datasource()
    {
        return Commande::query();
    }

    public function setUp()
    {
        $this->order('id', 'asc');
        $this->buttons('filters', 'csv', 'refresh','print');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Reference Commande'))
                ->data('reference_Commande'),

            Column::add(__('Date Commande'))
                ->width('180px')
                ->data('date_Commande')
                ->dateFormat(__("boilerplate::date.Ymd")),

            Column::add(__('Montant'))
                ->data('montant'),

            Column::add(__('Statut'))
                ->data('statut'),

            Column::add(__('Adresse Livraison'))
                ->data('adresse_livraison'),

            Column::add(__('Date Livraison'))
                ->width('180px')
                ->data('date_livraison')
                ->dateFormat(__("boilerplate::date.Ymd")),

            Column::add(__('Id Client'))
                ->data('id_Client'),

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
                ->actions(function (Commande $commande) {
                    return join([
                        // Button::show('commande.show', $commande),
                        // Button::edit('commande.edit', $commande),
                        // Button::delete('commande.destroy', $commande),
                    ]);
                }),
        ];
    }
}
