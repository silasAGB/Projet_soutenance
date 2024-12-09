<?php

namespace App\Datatables;

use App\Models\Produit;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class ProduitsDatatable extends Datatable
{
    public $slug = 'produits';

    public function datasource()
    {
        return Produit::with('categorie')->select('produits.*');
    }

    public function setUp()
    {
        $this->order('id', 'asc');
    }

    public function columns(): array
{
    return [

        Column::add(__('Reference'))
            ->data('reference_produit'),

        Column::add(__('Nom'))
            ->data('nom_produit'),

        Column::add(__('Prix Details'))
            ->data('prix_details_produit'),

        Column::add(__('Prix en Gros'))
            ->data('prix_gros_produit'),

        Column::add(__('Qte par Preparation'))
            ->data('qte_preparation'),

        Column::add(__('Qte en Stock'))
            ->data('qte_stock'),

        Column::add(__('Emplacement'))
            ->data('emplacement'),

        Column::add(__('Categorie'))
            ->data('categorie.nom_categorie'),

        Column::add()
            ->width('20px')
            ->actions(function (Produit $produit) {
                return join([
                    Button::show('boilerplate.produits.details', $produit->id_produit),
                    Button::edit('boilerplate.produits.edit', $produit->id_produit),
                    Button::delete('boilerplate.produits.destroy', $produit->id_produit),
                ]);
            }),
    ];
}
}
