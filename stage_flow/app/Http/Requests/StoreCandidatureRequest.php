<?php

namespace App\Http\Requests;

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
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'cv' => 'required|file|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:5120',
            'message_motivation' => 'required|string|min:50|max:2000',
            'telephone' => 'required|string|regex:/^(0[5-7])[0-9]{8}$/',
            'portfolio_url' => 'nullable|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'photo.image' => 'La photo doit être une image (JPG, PNG).',
            'photo.max' => 'La photo ne doit pas dépasser 2MB.',
            'cv.required' => 'Le CV est obligatoire.',
            'cv.mimes' => 'Le CV doit être en format PDF, DOC ou DOCX.',
            'cv.max' => 'Le CV ne doit pas dépasser 5MB.',
            'message_motivation.required' => 'La lettre de motivation est obligatoire.',
            'message_motivation.min' => 'La lettre de motivation doit faire au moins 50 caractères.',
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.regex' => 'Le numéro de téléphone doit être un numéro marocain valide.',
            'portfolio_url.url' => 'L\'URL du portfolio doit être une URL valide.',
        ];
    }
}
