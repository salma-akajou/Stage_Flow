<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEtablissementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'nom' => 'required|string|max:255|unique:etablissements,nom,' . $id,
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => "Le nom de l'établissement est obligatoire.",
            'nom.string' => "Le nom de l'établissement doit être une chaîne de caractères.",
            'nom.max' => "Le nom de l'établissement ne peut pas dépasser 255 caractères.",
            'nom.unique' => "Cet établissement existe déjà.",
        ];
    }
}
