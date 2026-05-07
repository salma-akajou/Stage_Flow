<?php

namespace App\Http\Requests\Entreprise;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom_entreprise' => 'required|string|max:255',
            'secteur'        => 'required|string|max:255',
            'ville_id'       => 'required|exists:villes,id',
            'adresse'        => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'site_web'       => 'nullable|url|max:255',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'prenom'         => 'required|string|max:255',
            'nom'            => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nom_entreprise.required' => 'Le nom de l\'entreprise est obligatoire.',
            'secteur.required'        => 'Le secteur d\'activité est obligatoire.',
            'ville_id.required'       => 'La ville est obligatoire.',
            'ville_id.exists'         => 'La ville sélectionnée est invalide.',
            'site_web.url'            => 'L\'adresse du site web doit être une URL valide.',
            'logo.image'              => 'Le logo doit être une image.',
            'logo.max'                => 'Le logo ne doit pas dépasser 2 Mo.',
            'prenom.required'         => 'Le prénom du responsable est obligatoire.',
            'nom.required'            => 'Le nom du responsable est obligatoire.',
        ];
    }
}
