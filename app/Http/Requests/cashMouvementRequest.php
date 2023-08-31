<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class cashMouvementRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'amount' => [
                'required',
                'numeric',
                'min:1',
            ],
            'mouvement_type' => [
                'required',
            ],
            'mouvement_description' => [
                'required',
            ],
            'image_url' => [
                'sometimes',
                'image',
            ],
        ];
        return $rules;
    }
}
