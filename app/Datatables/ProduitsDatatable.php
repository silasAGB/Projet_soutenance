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
        return Produit::query();
    }

    public function setUp()
    {
        $this->order('id', 'asc');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Reference Produit'))
                ->data('reference_produit'),

            Column::add(__('Nom Produit'))
                ->data('nom_produit'),

            Column::add(__('Description Produit'))
                ->data('description_produit'),

            Column::add(__('Prix Details Produit'))
                ->data('prix_details_produit'),

            Column::add(__('Prix Gros Produit'))
                ->data('prix_gros_produit'),

            Column::add(__('Qte Preparation'))
                ->data('qte_preparation'),

            Column::add(__('Qte Lot'))
                ->data('qte_lot'),

            Column::add(__('Qte Stock'))
                ->data('qte_stock'),

            Column::add(__('Stock Min'))
                ->data('stock_min'),

            Column::add(__('Emplacement'))
                ->data('Emplacement'),

            Column::add(__('Id Categorie'))
                ->data('id_Categorie'),

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
                ->actions(function (Produit $produit) {
                    return join([
                        // Button::show('produit.show', $produit),
                        Button::edit('boilerplate.produits.edit', $produit->id_produit),
                        Button::delete('boilerplate.produits.destroy', $produit->id_produit),
                    ]);
                }),
        ];
    }
}
