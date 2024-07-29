<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smallbox extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'quantité', 'unité', 'type'];
}
