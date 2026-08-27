<?php

namespace App\Http\Requests\PurchaseRequest;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePurchaseRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'request_number' => [
                'required',
                'integer',
                Rule::unique(
                    'purchase_requests',
                    'request_number'
                )->ignore($this->route('purchase_request')->id),
            ],

            'status' => [
                'required',
                Rule::in([
                    'complete',
                    'pending',
                    'active',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.raw_material_id' => [
                'required',
                'exists:raw_materials,id',
            ],

            'items.*.qty' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_id' => [
                'required',
                'exists:units,id',
            ],
        ];
    }
}
