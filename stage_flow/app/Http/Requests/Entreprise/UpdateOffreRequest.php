<?php

namespace App\Http\Requests\Entreprise;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOffreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type_stage' => 'required|in:PFE,Technique,Observation',
            'duree' => 'required|string|max:100',
            'remuneration' => 'required|in:Payé,Non-payé',
            'format' => 'required|in:Hybride,Télétravail,Présentiel',
            'ville_id' => 'required|exists:villes,id',
            'responsabilites' => 'required|string',
            'profil_recherche' => 'required|string',
            'competences_techniques' => 'nullable|string',
            'status' => 'required|in:Active,Expirée',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre de l\'offre est obligatoire.',
            'description.required' => 'La description de l\'offre est obligatoire.',
            'type_stage.required' => 'Le type de stage est obligatoire.',
            'type_stage.in' => 'Le type de stage sélectionné est invalide.',
            'duree.required' => 'La durée du stage est obligatoire.',
            'remuneration.required' => 'Le type de rémunération est obligatoire.',
            'format.required' => 'Le format de travail est obligatoire.',
            'ville_id.required' => 'La ville est obligatoire.',
            'ville_id.exists' => 'La ville sélectionnée n\'existe pas.',
            'responsabilites.required' => 'Les responsabilités sont obligatoires.',
            'profil_recherche.required' => 'Le profil recherché est obligatoire.',
            'status.required' => 'Le statut de l\'offre est obligatoire.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.date' => 'La date de début n\'est pas valide.',
            'date_fin.required' => 'La date de fin est obligatoire.',
            'date_fin.date' => 'La date de fin n\'est pas valide.',
            'date_fin.after' => 'La date de fin doit être après la date de début.',
        ];
    }


    /**
     * Transformer les données après validation
     */
    protected function passedValidation()
    {
        if ($this->has('competences_techniques') && is_string($this->competences_techniques)) {
            $this->merge([
                'competences_techniques' => json_decode($this->competences_techniques, true) ?? []
            ]);
        }
    }
}
