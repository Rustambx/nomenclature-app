<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\ApiRequest;

class CategoryStoreRequest extends ApiRequest
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
            'name' => 'required',
            'parent_id' => 'nullable|uuid|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле name обязательно',
            'parent_id.exists' => 'Выбранная категория не существует.'
        ];
    }
}
