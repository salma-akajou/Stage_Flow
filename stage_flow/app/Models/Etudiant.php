<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    
    protected $fillable = [
        'user_id',
        'ville_id',
        'etablissement',
        'filiere',
        'niveau_etudes',
        'photo',
        'bio',
        'github',
        'linkedin',
        'vues',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'etudiant_id', 'user_id');
    }

    public function documentCvs()
    {
        return $this->hasMany(DocumentCv::class, 'etudiant_id', 'user_id');
    }

    public function favoris()
    {
        return $this->belongsToMany(Offre::class, 'favoris', 'etudiant_id', 'offre_id')
                    ->withPivot('date_ajout')
                    ->withTimestamps();
    }
}
