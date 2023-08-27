<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TableRequest extends FormRequest
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
            'table_nb' => [
                'required',
                'integer',
                'unique:tables',
            ],
            'seats' => [
                'sometimes',
                'integer',
            ],
        ];
        if ($this->method() == Request::METHOD_PUT) {
            $rules['table_nb'][2] = Rule::unique('tables')->ignore($this->route()->parameter('table'));
        }
        return $rules;
    }
}
