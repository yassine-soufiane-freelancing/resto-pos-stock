<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            'order_status' => [
                'required',
                'string',
            ],
            'is_paid' => [
                'sometimes',
                'boolean',
            ],
            'is_take_away' => [
                'sometimes',
                'boolean',
            ],
            'payment_type' => [
                'sometimes',
                'string',
            ],
            'order_note' => [
                'sometimes',
                'string',
            ],
            'client' => [
                'sometimes',
                'integer',
                'exists:clients,id',
            ],
            'table' => [
                'sometimes',
                'integer',
                'exists:tables,id',
            ],
            'nb_seats' => [
                'sometimes',
                'integer',
            ],
        ];
        return $rules;
    }
}
