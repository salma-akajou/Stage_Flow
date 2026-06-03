<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = ['nom'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'filiere_id', 'user_id');
    }
}
