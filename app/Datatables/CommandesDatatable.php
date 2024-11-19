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

            Column::add(__('Reference'))
                ->data('reference_commande'),

            Column::add(__('Date'))
                ->width('180px')
                ->data('date_commande')
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

            Column::add(__('Client'))
                ->data('id_client'),


            Column::add()
                ->width('20px')
                ->actions(function (Commande $commande) {

                    $actions = [];

                    $actions[] = Button::show('boilerplate.commandes.details', $commande);

                    if (!in_array($commande->statut, ['livré', 'Terminé'])) {
                        $actions[] = Button::edit('boilerplate.commandes.edit', $commande);
                    }

                    if (!in_array($commande->statut, ['livré', 'Terminé'])) {
                        $actions[] = Button::delete('boilerplate.commandes.destroy', $commande);
                    }

                    return join($actions
                        // Button::show('commande.show', $commande),
                        // Button::edit('commande.edit', $commande),
                        // Button::delete('commande.destroy', $commande),
                    );
                }),
            ];
    }
}
