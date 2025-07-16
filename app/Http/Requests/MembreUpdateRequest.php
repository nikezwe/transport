<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembreUpdateRequest extends FormRequest
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
            'nom' => ['required', 'string'],
            'prenom' => ['required', 'string'],
            'image' => ['nullable', 'image' ],
            'designation' => ['required', 'string'],
            'fb_link' => ['nullable', 'string'],
            'tw_link' => ['nullable', 'string'],
            'ig_link' => ['nullable', 'string'],
        ];
    }
}
