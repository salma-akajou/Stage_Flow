<?php

namespace App\Http\Requests\Student;

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
            'prenom'        => 'required|string|max:255',
            'nom'           => 'required|string|max:255',
            'ville_id'      => 'required|exists:villes,id',
            'etablissement' => 'required|string|max:255',
            'filiere'       => 'required|string|max:255',
            'niveau_etudes' => 'required|string|max:255',
            'bio'           => 'nullable|string|max:1000',
            'github'        => 'nullable|url|max:255',
            'linkedin'      => 'nullable|url|max:255',
            'photo'         => 'nullable|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'prenom.required'        => 'Le prénom est obligatoire.',
            'nom.required'           => 'Le nom est obligatoire.',
            'ville_id.required'      => 'La ville est obligatoire.',
            'etablissement.required' => 'L\'établissement est obligatoire.',
            'filiere.required'       => 'La filière est obligatoire.',
            'photo.image'            => 'La photo doit être une image.',
            'photo.max'              => 'La photo ne doit pas dépasser 2 Mo.',
        ];
    }
}
