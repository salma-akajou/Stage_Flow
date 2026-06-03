<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Secteur extends Model
{
    protected $fillable = ['nom'];

    public function entreprises()
    {
        return $this->hasMany(Entreprise::class, 'secteur_id');
    }

    public function offres()
    {
        return $this->hasMany(Offre::class, 'secteur_id');
    }
}
