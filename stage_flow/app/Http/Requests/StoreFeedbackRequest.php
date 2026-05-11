<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string|min:5|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'note.required' => 'Veuillez attribuer une note.',
            'note.integer' => 'La note doit être un nombre entier.',
            'commentaire.required' => 'Votre avis ne peut pas être vide.',
            'commentaire.min' => 'Votre avis doit faire au moins 5 caractères.',
        ];
    }
}
