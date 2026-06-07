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
                'etablissement_id' => ['required', 'exists:etablissements,id'],
                'filiere_id' => ['required', 'exists:filieres,id'],
                'niveau_etude' => ['required', 'string', 'in:Bac+2,Bac+3,Bac+5,Doctorat'],
                'photo' => [
                    'nullable',
                    'max:2048',
                    function ($attribute, $value, $fail) {
                        if ($value instanceof \Illuminate\Http\UploadedFile) {
                            $extension = strtolower($value->getClientOriginalExtension());
                            $allowedExtensions = ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp'];
                            if (!in_array($extension, $allowedExtensions)) {
                                $fail('La photo doit être au format jpeg, png, jpg, gif, svg ou webp.');
                            }
                        }
                    }
                ],
                'github' => ['nullable', 'url', 'max:255'],
                'linkedin' => ['nullable', 'url', 'max:255'],
            ]);
        } elseif ($this->role === 'entreprise') {
            $rules = array_merge($rules, [
                'nom_entreprise' => ['required', 'string', 'max:255'],
                'secteur_id' => ['required', 'exists:secteurs,id'],
                'ville_id' => ['required', 'exists:villes,id'],
                'adresse' => ['required', 'string', 'max:500'],
                'email_contact' => ['required', 'email', 'max:255'],
                'registre_commerce' => ['required', 'string', 'max:100'],
                'logo' => [
                    'nullable',
                    'max:2048',
                    function ($attribute, $value, $fail) {
                        if ($value instanceof \Illuminate\Http\UploadedFile) {
                            $extension = strtolower($value->getClientOriginalExtension());
                            $allowedExtensions = ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp'];
                            if (!in_array($extension, $allowedExtensions)) {
                                $fail('Le logo doit être au format jpeg, png, jpg, gif, svg ou webp.');
                            }
                        }
                    }
                ],
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
            'etablissement_id.exists' => 'Établissement invalide.',
            'nom.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit faire au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'role.required' => 'Veuillez choisir un profil.',
            'ville_id.required' => 'La ville est obligatoire.',
            'etablissement_id.required' => 'L\'établissement est obligatoire.',
            'filiere_id.required' => 'La filière est obligatoire.',
            'niveau_etude.required' => 'Le niveau d\'études est obligatoire.',
            'nom_entreprise.required' => 'Le nom de l\'entreprise est obligatoire.',
            'secteur_id.required' => 'Le secteur d\'activité est obligatoire.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'email_contact.required' => 'L\'email de contact est obligatoire.',
            'registre_commerce.required' => 'Le numéro de RC est obligatoire.',
            'taille.required' => 'La taille de l\'entreprise est obligatoire.',
            'photo.image' => 'La photo doit être une image.',
            'photo.mimes' => 'La photo doit être au format jpeg, png, jpg, gif, svg ou webp.',
            'logo.image' => 'Le logo doit être une image.',
            'logo.mimes' => 'Le logo doit être au format jpeg, png, jpg, gif, svg ou webp.',
        ];
    }
}
