<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'nom_entreprise',
        'secteur_id',
        'ville_id',
        'adresse',
        'email_contact',
        'bio',
        'registre_commerce',
        'logo',
        'taille',
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

    public function secteur()
    {
        return $this->belongsTo(Secteur::class, 'secteur_id');
    }

    public function offres()
    {
        return $this->hasMany(Offre::class, 'entreprise_id', 'user_id');
    }

}
