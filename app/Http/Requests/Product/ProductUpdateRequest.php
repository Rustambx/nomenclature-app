<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\ApiRequest;

class ProductUpdateRequest extends ApiRequest
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
            "name" => "required|string",
            "description" => "required|string",
            "category_id" => "required|uuid|exists:categories,id",
            "supplier_id" => "required|uuid|exists:suppliers,id",
            "price" => "required|numeric",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле name обязательно',
            'description.required' => 'Поле description обязательно',
            'category_id.required' => 'Поле category_id обязательно',
            'category_id.exists' => 'Выбранная категория не существует.',
            'supplier_id.required' => 'Поле supplier_id обязательно',
            'supplier_id.exists' => 'Выбранный поставщик не существует',
            'price.required' => 'Поле price обязательно',
            'price.numeric' => 'Поле price должно быть числом',
        ];
    }
}
