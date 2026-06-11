<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

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
        'photo',
        'portfolio_url',
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

    protected static function booted()
    {
        static::deleting(function ($candidature) {
            Notification::where('data->candidature_id', $candidature->id)->delete();
        });
    }
}
