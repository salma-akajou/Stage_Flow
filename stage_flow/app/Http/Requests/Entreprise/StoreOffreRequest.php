<?php

namespace App\Http\Requests\Entreprise;

use Illuminate\Foundation\Http\FormRequest;

class StoreOffreRequest extends FormRequest
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
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
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

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre de l\'offre est obligatoire.',
            'description.required' => 'La description est nécessaire pour attirer les candidats.',
            'type_stage.required' => 'Veuillez choisir un type de stage.',
            'type_stage.in' => 'Le type de stage sélectionné n\'est pas valide.',
            'duree.required' => 'La durée du stage est obligatoire.',
            'remuneration.required' => 'Veuillez préciser si le stage est payé ou non.',
            'format.required' => 'Le format est obligatoire.',
            'ville_id.required' => 'La ville est obligatoire.',
            'ville_id.exists' => 'La ville sélectionnée n\'existe pas.',
            'responsabilites.required' => 'Veuillez lister les missions du stagiaire.',
            'profil_recherche.required' => 'Veuillez détailler le profil recherché.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.after_or_equal' => 'La date de début ne peut pas être dans le passé.',
            'date_fin.required' => 'La date de fin est obligatoire.',
            'date_fin.after' => 'La date de fin doit être après la date de début.',
            'status.required' => 'Le statut de visibilité est obligatoire.',
        ];
    }
}
