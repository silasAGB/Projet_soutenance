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
                ->data('nom_fournisseur', function($data){
                    $nom = '<div>';
                    if($data->nom_fournisseur)
                    {
                        $nom .= '<div><strong><i class="fa fa-user mr-2"></i>'.$data->nom_fournisseur.'</strong></div>';
                    }
                    return $nom;
                }),

            Column::add(__('Contact'))
                ->class('text-nowrap')
                ->data('contact_fournisseur', function($data){
                    $contacts = '<div>';
                    if($data->contact_fournisseur)
                    {
                        $contacts .= '<div><strong><i class="fa fa-phone mr-2"></i>'.$data->contact_fournisseur.'</strong></div>';
                    }
                    return $contacts;
                }),

            Column::add(__('Email'))
                ->class('text-nowrap')
                ->data('email_fournisseur', function($data){
                    $emails = '<div>';
                    if($data->email_fournisseur)
                    {
                        $emails = '<div><strong><i class="fa fa-envelope mr-2"></i>'.$data->email_fournisseur.'</strong></div>';
                    }
                    return $emails;
                }),

            Column::add(__('Adresse'))
                ->data('adresse_fournisseur', function($data){
                    $adresses = '<div>';
                    if($data->adresse_fournisseur)
                    {
                        $adresses .= '<div><strong><i class="fa fa-map-marker mr-2"></i>'.$data->adresse_fournisseur.'</strong></div>';
                    }
                    return $adresses;
                }),

            Column::add()
                ->width('20px')
                ->actions(function (Fournisseur $fournisseur) {
                    return join([
                        Button::edit('boilerplate.fournisseur.edit', $fournisseur),
                        Button::delete('boilerplate.fournisseur.destroy', $fournisseur, [
                            'data' => [
                                'confirm' => __('Are you sure you want to delete this item?'),
                                'method' => 'delete',
                            ],
                        ]),

                    ]);
                }),
        ];
    }
}
