<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:etudiant,entreprise'],
        ];

        if ($this->role === 'etudiant') {
            $rules = array_merge($rules, [
                'ville_id' => ['required', 'exists:villes,id'],
                'etablissement' => ['required', 'string', 'in:Solicode,Faculté,ISTA,EMSI,ENSI,BTS,Autre'],
                'filiere' => ['required', 'string', 'max:255'],
                'niveau_etude' => ['required', 'string', 'in:Bac+2,Bac+3,Master,Doctorat,Autre'],
                'photo' => ['nullable', 'image', 'max:2048'],
                'github' => ['nullable', 'url', 'max:255'],
                'linkedin' => ['nullable', 'url', 'max:255'],
            ]);
        } elseif ($this->role === 'entreprise') {
            $rules = array_merge($rules, [
                'nom_entreprise' => ['required', 'string', 'max:255'],
                'secteur' => ['required', 'string', 'in:Informatique,Design,Marketing,Commerce,Industrie,Autre'],
                'ville_id' => ['required', 'exists:villes,id'],
                'adresse' => ['required', 'string', 'max:500'],
                'email_contact' => ['required', 'email', 'max:255'],
                'registre_commerce' => ['required', 'string', 'max:100'],
                'logo' => ['nullable', 'image', 'max:2048'],
                'taille' => ['required', 'string', 'in:TPE / PME,Grande Entreprise,Multinationale'],
            ]);
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'prenom.required' => 'Le prénom est obligatoire.',
            'nom.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit faire au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'role.required' => 'Veuillez choisir un profil.',
            'ville_id.required' => 'La ville est obligatoire.',
            'etablissement.required' => 'L\'établissement est obligatoire.',
            'filiere.required' => 'La filière est obligatoire.',
            'niveau_etude.required' => 'Le niveau d\'études est obligatoire.',
            'nom_entreprise.required' => 'Le nom de l\'entreprise est obligatoire.',
            'secteur.required' => 'Le secteur d\'activité est obligatoire.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'email_contact.required' => 'L\'email de contact est obligatoire.',
            'registre_commerce.required' => 'Le numéro de RC est obligatoire.',
            'taille.required' => 'La taille de l\'entreprise est obligatoire.',
            'photo.image' => 'La photo doit être une image.',
            'logo.image' => 'Le logo doit être une image.',
        ];
    }
}
