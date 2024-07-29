<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributeur extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_Distributeur';

    protected $fillable = ['id_Client'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_Client');
    }
}
