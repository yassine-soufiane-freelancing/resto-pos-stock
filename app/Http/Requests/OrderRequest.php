<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use App\Models\ItemVariation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Enum\Laravel\Rules\EnumRule;

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
                new EnumRule(OrderStatus::class),
            ],
            'is_paid' => [
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
            'order_discount' => [
                'sometimes',
                'numeric',
            ],
            'item_variations' => [
                'required',
                'array',
            ],
            'item_variations.*' => [
                Rule::in(ItemVariation::all()->modelKeys()),
            ],
            'item_variations.*.item_quantity' => [
                'integer',
            ],
            'item_variations.*.item_note' => [
                'string',
            ],
            'client' => [
                'sometimes',
                'integer',
                'exists:clients,id',
            ],
            'table' => [
                'required_without_all:import,delivery',
                'integer',
                'exists:tables,id',
            ],
            'nb_seats' => [
                'sometimes',
                'integer',
            ],
            'import' => [
                'required_without_all:table,delivery',
                'accepted',
            ],
            'delivery' => [
                'required_without_all:table,import',
                'accepted',
            ],
            'delivery_man' => [
                'required_with_all:delivery',
                'integer',
            ],
            'delivery_man.name' => [
                'required',
                'string',
            ],
            'delivery_man.phone' => [
                'required',
                'string',
            ],
        ];
        return $rules;
    }
}
