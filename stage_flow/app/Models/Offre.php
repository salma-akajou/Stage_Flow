<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'type_stage',
        'duree',
        'remuneration',
        'format',
        'secteur',
        'ville_id',
        'responsabilites',
        'profil_recherche',
        'competences_techniques',
        'status',
        'date_publication',
        'date_debut',
        'date_fin',
        'entreprise_id',
    ];

    protected $casts = [
        'competences_techniques' => 'json',
        'date_publication' => 'datetime',
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id', 'user_id');
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(Etudiant::class, 'favoris', 'offre_id', 'etudiant_id')
                    ->withPivot('date_ajout')
                    ->withTimestamps();
    }
}
