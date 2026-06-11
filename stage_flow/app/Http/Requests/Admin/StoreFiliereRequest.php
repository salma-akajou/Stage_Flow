<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFiliereRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255|unique:filieres,nom',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la filière est obligatoire.',
            'nom.string' => 'Le nom de la filière doit être une chaîne de caractères.',
            'nom.max' => 'Le nom de la filière ne peut pas dépasser 255 caractères.',
            'nom.unique' => 'Cette filière existe déjà.',
        ];
    }
}
