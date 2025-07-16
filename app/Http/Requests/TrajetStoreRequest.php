<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrajetStoreRequest extends FormRequest
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
            'pays_depart_id' => ['required', 'integer', 'exists:pays,id'],
            'pays_arrivee_id' => ['required', 'integer', 'exists:pays,id'],
            'ville_depart' => ['required', 'string'],
            'ville_arrivee' => ['required', 'string'],
            'date_depart' => ['required', 'date'],
            'date_arrivee' => ['required', 'date'],
        ];
    }
}
