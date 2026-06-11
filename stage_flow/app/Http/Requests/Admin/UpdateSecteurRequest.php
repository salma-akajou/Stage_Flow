<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSecteurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'nom' => 'required|string|max:255|unique:secteurs,nom,' . $id,
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du secteur est obligatoire.',
            'nom.string' => 'Le nom du secteur doit être une chaîne de caractères.',
            'nom.max' => 'Le nom du secteur ne peut pas dépasser 255 caractères.',
            'nom.unique' => 'Ce secteur existe déjà.',
        ];
    }
}
