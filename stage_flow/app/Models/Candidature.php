<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    protected $fillable = [
        'statut',
        'telephone',
        'message_motivation',
        'date_postulation',
        'etudiant_id',
        'offre_id',
        'cv_id',
    ];

    protected $casts = [
        'date_postulation' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id', 'user_id');
    }

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }

    public function cv()
    {
        return $this->belongsTo(DocumentCv::class, 'cv_id');
    }
}
