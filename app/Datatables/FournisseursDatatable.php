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
        $this->buttons('filters', 'csv', 'refresh','print','excel');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Nom'))
                ->data('nom_fournisseur'),

            Column::add(__('Contact'))
                ->data('contact_fournisseur'),

            Column::add(__('Email'))
                ->data('email_fournisseur'),

            Column::add(__('Adresse'))
                ->data('adresse_fournisseur'),

            Column::add()
                ->width('20px')
                ->actions(function (Fournisseur $fournisseur) {
                    return join([
                        Button::edit('boilerplate.fournisseur.edit', $fournisseur),
                    ]);
                }),
        ];
    }
}
