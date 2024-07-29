<?php

namespace App\Datatables;

use App\Models\fournisseur;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class FournisseursDatatable extends Datatable
{
    public $slug = 'fournisseurs';

    public function datasource()
    {
        //return Fournisseur::query();

        return Fournisseur::select([
            'id_fournisseur',
            'nom_fournisseur',
            'contact_fournisseur',
            'email_fournisseur',
            'adresse_fournisseur',
            'created_at',
            'updated_at'
        ]);
    }

    public function setUp()
    {
        $this->order('id', 'asc');
        $this->buttons('filters', 'csv', 'refresh','print');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Nom Fournisseur'))
                ->data('nom_fournisseur'),

            Column::add(__('Contact Fournisseur'))
                ->data('contact_fournisseur'),

            Column::add(__('Email Fournisseur'))
                ->data('email_fournisseur'),

            Column::add(__('Adresse Fournisseur'))
                ->data('adresse_fournisseur'),

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
                ->actions(function (Fournisseur $fournisseur) {
                    return join([
                        Button::show('boilerplate.fournisseur.show', $fournisseur),
                        Button::edit('boilerplate.fournisseur.edit', $fournisseur),
                        Button::delete('boilerplate.fournisseur.destroy', $fournisseur),
                    ]);
                }),
        ];
    }
}
