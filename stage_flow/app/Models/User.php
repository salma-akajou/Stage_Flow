<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'prenom',
        'nom',
        'email',
        'password',
    ];

    protected $appends = ['role', 'avatar_url'];

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class);
    }

    public function entreprise()
    {
        return $this->hasOne(Entreprise::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'auteur_id');
    }

    public function getRoleAttribute(): string
    {
        if ($this->etudiant) return 'etudiant';
        if ($this->entreprise) return 'entreprise';
        
        // Fallback si non chargé
        if ($this->etudiant()->exists()) return 'etudiant';
        if ($this->entreprise()->exists()) return 'entreprise';
        
        return 'admin';
    }

    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->role === 'etudiant' && $this->etudiant) {
            return $this->etudiant->photo;
        }
        if ($this->role === 'entreprise' && $this->entreprise) {
            return $this->entreprise->logo;
        }
        return null;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
