<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'price' => 'numeric',
            'stock' => 'integer',
            'description' => 'string',
            'provider_id' => 'exists:providers,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.string' => 'The name field must be a string.',
            'price.numeric' => 'The price field must be a number.',
            'stock.integer' => 'The stock field must be an integer.',
            'description.string' => 'The description field must be a string.',
            'provider_id.exists' => 'The selected provider_id is invalid.',
        ];
    }
}
