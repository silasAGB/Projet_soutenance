<?php
namespace App\Datatables;

use App\Models\Approvisionnement;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class ApprovisionnementsDatatable extends Datatable
{
    public $slug = 'approvisionnements';

    public function datasource()
    {
        return Approvisionnement::query()->select([
            'id_approvisionnement',
            'date_approvisionnement',
            'reference_approvisionnement',
            'montant',
            'statut',
            'created_at',
            'updated_at'
        ]);
    }

    public function setUp()
    {
        $this->order('id_approvisionnement', 'desc');
        $this->buttons('filters', 'csv', 'refresh', 'print');
    }

    public function columns(): array
    {
        return [

            Column::add(__('Référence'))
            ->data('reference_approvisionnement'),

            Column::add(__('Date prévue'))
                ->width('180px')
                ->data('date_approvisionnement')
                ->dateFormat(__("boilerplate::date.Ymd")),

            Column::add(__('Montant'))
                ->data('montant'),

            Column::add(__('Statut'))
                ->data('statut'),

            Column::add()
                ->width('20px')
                ->actions(function (Approvisionnement $approvisionnement) {
                    // Condition pour masquer le bouton de modification si l'approvisionnement est livré ou terminé
                    $actions = [];

                    $actions[] = Button::show('boilerplate.approvisionnements.details', $approvisionnement);

                    if (!in_array($approvisionnement->statut, ['livré', 'Terminé'])) {
                        $actions[] = Button::edit('boilerplate.approvisionnements.edit', $approvisionnement);
                    }

                    // Toujours permettre la suppression sauf si livré ou terminé
                    if (!in_array($approvisionnement->statut, ['livré', 'Terminé'])) {
                        $actions[] = Button::delete('boilerplate.approvisionnements.destroy', $approvisionnement);
                    }

                    return join($actions);
                }),
        ];
    }
}
