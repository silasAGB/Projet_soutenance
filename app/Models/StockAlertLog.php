<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAlertLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_mp',
        'qte_stock',
        'stock_min',
        'status',
        'error'
    ];

    /**
     * Relation avec la matière première
     */
    public function matierePremiere()
    {
        return $this->belongsTo(MatierePremiere::class, 'id_mp', 'id_MP');
    }
}
