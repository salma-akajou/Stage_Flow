<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $fillable = ['nom'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function entreprises()
    {
        return $this->hasMany(Entreprise::class);
    }

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
}
