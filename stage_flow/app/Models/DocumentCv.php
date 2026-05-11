<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentCv extends Model
{
    protected $fillable = [
        'file_path',
        'date_upload',
        'etudiant_id',
    ];

    protected $casts = [
        'date_upload' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id', 'user_id');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'cv_id');
    }
}
