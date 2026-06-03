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
            'prenom'           => 'required|string|max:255',
            'nom'              => 'required|string|max:255',
            'ville_id'         => 'required|exists:villes,id',
            'etablissement_id' => 'required|exists:etablissements,id',
            'filiere_id'       => 'required|exists:filieres,id',
            'niveau_etudes'    => 'required|string|in:Bac+2,Bac+3,Bac+5,Doctorat',
            'bio'              => 'nullable|string|max:1000',
            'github'           => 'nullable|url|max:255',
            'linkedin'         => 'nullable|url|max:255',
            'photo'            => 'nullable|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'prenom.required'           => 'Le prénom est obligatoire.',
            'nom.required'              => 'Le nom est obligatoire.',
            'ville_id.required'         => 'La ville est obligatoire.',
            'etablissement_id.required' => 'L\'établissement est obligatoire.',
            'filiere_id.required'       => 'La filière est obligatoire.',
            'photo.image'               => 'La photo doit être une image.',
            'photo.max'                 => 'La photo ne doit pas dépasser 2 Mo.',
        ];
    }
}
