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
        'secteur_id',
        'ville_id',
        'responsabilites',
        'profil_recherche',
        'status',
        'date_publication',
        'date_debut',
        'date_fin',
        'entreprise_id',
    ];

    protected $casts = [
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

    public function secteur()
    {
        return $this->belongsTo(Secteur::class, 'secteur_id');
    }

    public function competences()
    {
        return $this->belongsToMany(Competence::class, 'competence_offre', 'offre_id', 'competence_id');
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
