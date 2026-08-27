<?php

namespace App\Http\Requests\Quotation;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuotationRequest extends FormRequest
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
            'vendor_id' => [
                'required',
                'exists:vendors,id',
            ],

            'quotation_number' => [
                'nullable',
                'integer',
            ],

            'status' => [
                'required',
                'in:pending,accepted',
            ],

            'quotation_date' => [
                'required',
                'date',
            ],

            'valid_until' => [
                'nullable',
                'date',
                'after_or_equal:quotation_date',
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
                'numeric',
                'min:0.001',
            ],

            'items.*.unit_id' => [
                'required',
                'exists:units,id',
            ],

            'items.*.price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }
}
