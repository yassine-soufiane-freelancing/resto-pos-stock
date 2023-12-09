<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserRequest extends FormRequest
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
            'name' => [
                'required',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique(User::class),
            ],
            'role' => [
                'required',
                'integer',
                Rule::exists(Role::class, 'id'),
            ],
        ];
        if ($this->method() == Request::METHOD_PUT) {
            $rules['email'][2] = Rule::unique(User::class)->ignore($this->route()->parameter('user')) ;
            $rules['password'] = [
                'sometimes',
                'confirmed',
            ];
            $rules['password_confirmation'] = [
                'required_with:password',
                'string',
                'min:8',
                'max:16',
            ];
        }
        return $rules;
    }
}
