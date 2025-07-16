<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
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
            'trajet_id' => ['required', 'integer', 'exists:trajets,id'],
            'description' => ['required', 'string'],
            'date_depart' => ['required'],
            'prix' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'type' => ['required', 'string'],
        ];
    }
}
