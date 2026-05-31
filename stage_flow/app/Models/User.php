<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

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

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function getRoleAttribute(): string
    {
        if (method_exists($this, 'getRoleNames') && $this->getRoleNames()->isNotEmpty()) {
            return $this->getRoleNames()->first();
        }
        if ($this->etudiant) return 'etudiant';
        if ($this->entreprise) return 'entreprise';
        
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
     * Enregistre un étudiant avec son profil associé.
     */
    public static function registerStudent(array $data): self
    {
        return DB::transaction(function() use ($data) {
            $user = self::create([
                'prenom'   => $data['prenom'],
                'nom'      => $data['nom'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            if (method_exists($user, 'assignRole')) {
                $user->assignRole('etudiant');
            }

            $photoPath = null;
            if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
                $photoPath = $data['photo']->store('avatars', 'public');
            }

            Etudiant::create([
                'user_id'       => $user->id,
                'ville_id'      => $data['ville_id'],
                'etablissement' => $data['etablissement'],
                'filiere'       => $data['filiere'],
                'niveau_etudes' => $data['niveau_etude'],
                'photo'         => $photoPath,
                'bio'           => $data['bio'] ?? null,
                'github'        => $data['github'] ?? null,
                'linkedin'      => $data['linkedin'] ?? null,
                'vues'          => 0,
            ]);

            return $user;
        });
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
