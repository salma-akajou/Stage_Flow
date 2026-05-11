<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'offre_id' => 'required|exists:offres,id',
            'cv' => 'required|file|mimes:pdf|max:20480',
            'message_motivation' => 'required|string|min:20',
            'telephone' => 'required|string|max:20',
            'portfolio_url' => 'nullable|url',
            'photo' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'offre_id.required' => 'L\'offre sélectionnée est invalide.',
            'offre_id.exists' => 'L\'offre sélectionnée n\'existe pas.',
            'cv.required' => 'Le CV est obligatoire.',
            'cv.mimes' => 'Le CV doit être au format PDF.',
            'cv.max' => 'Le CV ne doit pas dépasser 20 Mo.',
            'message_motivation.required' => 'La lettre de motivation est obligatoire.',
            'message_motivation.min' => 'Votre lettre de motivation doit faire au moins 20 caractères.',
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'portfolio_url.url' => 'L\'URL du portfolio est invalide.',
            'photo.image' => 'La photo doit être une image valide.',
            'photo.max' => 'La photo ne doit pas dépasser 2 Mo.',
        ];
    }
}
