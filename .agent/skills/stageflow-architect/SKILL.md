---
name: stageflow-architect
description: Gestion de l'architecture de la base de données, des migrations, des modèles Eloquent et des relations de StageFlow.
---

# 🏗️ COMPÉTENCE : STAGEFLOW ARCHITECT

## Rôle et Domaine d'Action
Cette compétence gère l'architecture de données du projet **StageFlow**. Elle s'assure du bon typage des colonnes, de l'ordre des migrations et de l'intégrité référentielle entre les modèles.

## Les Modèles et Leurs Relations

### 1. Modèle User
```php
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = ['prenom', 'nom', 'email', 'password'];
    protected $appends = ['role', 'avatar_url'];

    public function etudiant() { return $this->hasOne(Etudiant::class); }
    public function entreprise() { return $this->hasOne(Entreprise::class); }
    public function feedbacks() { return $this->hasMany(Feedback::class, 'auteur_id'); }
}
```

### 2. Modèle Etudiant
```php
class Etudiant extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $fillable = ['user_id', 'ville_id', 'etablissement', 'filiere', 'niveau_etudes', 'photo', 'bio', 'github', 'linkedin', 'vues'];

    public function user() { return $this->belongsTo(User::class); }
    public function ville() { return $this->belongsTo(Ville::class); }
    public function candidatures() { return $this->hasMany(Candidature::class, 'etudiant_id', 'user_id'); }
    public function documentCvs() { return $this->hasMany(DocumentCv::class, 'etudiant_id', 'user_id'); }
    public function favoris() {
        return $this->belongsToMany(Offre::class, 'favoris', 'etudiant_id', 'offre_id')
                    ->withPivot('date_ajout')
                    ->withTimestamps();
    }
}
```

### 3. Modèle Entreprise
```php
class Entreprise extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $fillable = ['user_id', 'nom_entreprise', 'secteur', 'ville_id', 'adresse', 'email_contact', 'bio', 'registre_commerce', 'logo', 'taille'];

    public function user() { return $this->belongsTo(User::class); }
    public function ville() { return $this->belongsTo(Ville::class); }
    public function offres() { return $this->hasMany(Offre::class, 'entreprise_id', 'user_id'); }
}
```

### 4. Modèle Offre
```php
class Offre extends Model
{
    protected $fillable = ['titre', 'description', 'type_stage', 'duree', 'remuneration', 'format', 'secteur', 'ville_id', 'responsabilites', 'profil_recherche', 'competences_techniques', 'status', 'date_publication', 'date_debut', 'date_fin', 'entreprise_id'];
    protected $casts = [
        'competences_techniques' => 'json',
        'date_publication' => 'datetime',
        'date_debut' => 'date',
        'date_fin' => 'date'
    ];

    public function entreprise() { return $this->belongsTo(Entreprise::class, 'entreprise_id', 'user_id'); }
    public function ville() { return $this->belongsTo(Ville::class); }
    public function candidatures() { return $this->hasMany(Candidature::class); }
}
```

### 5. Modèle Candidature
```php
class Candidature extends Model
{
    protected $fillable = ['statut', 'telephone', 'message_motivation', 'date_postulation', 'etudiant_id', 'offre_id', 'cv_id', 'photo', 'portfolio_url'];
    protected $casts = ['date_postulation' => 'datetime'];

    public function etudiant() { return $this->belongsTo(Etudiant::class, 'etudiant_id', 'user_id'); }
    public function offre() { return $this->belongsTo(Offre::class); }
    public function cv() { return $this->belongsTo(DocumentCv::class, 'cv_id'); }
}
```

## Directives d'Intégrité de Données
*   Toutes les clés étrangères doivent porter des contraintes d'intégrité claires en base de données (ex: `onDelete('cascade')`).
*   Ne jamais utiliser `$guarded = []`. Toujours définir `$fillable` explicitement dans chaque modèle pour se prémunir des failles d'assignation de masse.
