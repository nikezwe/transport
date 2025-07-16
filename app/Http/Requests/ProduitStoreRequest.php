<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'membre_id' => ['required', 'integer', 'exists:membres,id'],
            'nom' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'poids' => ['nullable', 'numeric', 'between:-999999.99,999999.99'],
            'est_publie' => ['required'],
        ];
    }
}
