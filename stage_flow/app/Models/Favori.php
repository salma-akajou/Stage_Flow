<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Favori extends Pivot
{
    protected $table = 'favoris';

    protected $fillable = [
        'etudiant_id',
        'offre_id',
        'date_ajout',
    ];

    protected $casts = [
        'date_ajout' => 'datetime',
    ];
}
