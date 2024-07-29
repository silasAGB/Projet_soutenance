<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_Client';

    protected $fillable = ['nom_Client', 'contact_Client', 'adresse_Client'];

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'id_Client');
    }
}
