<?php

namespace App\Exports;

use App\Models\Mouvement;
use App\Models\MouvementProduit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MouvementsExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return MouvementProduit::with('produit')
            ->when($this->filters['produit'] ?? null, function ($query) {
                return $query->where('produit_id', $this->filters['produit']);
            })
            ->when($this->filters['start_date'] ?? null, function ($query) {
                return $query->where('date_mouvement', '>=', $this->filters['start_date']);
            })
            ->when($this->filters['end_date'] ?? null, function ($query) {
                return $query->where('date_mouvement', '<=', $this->filters['end_date']);
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Produit',
            'Type',
            'Quantité',
            'Stock Disponible',
        ];
    }
}
