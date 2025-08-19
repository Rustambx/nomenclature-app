<?php

namespace App\Http\Requests\Supplier;

use App\Http\Requests\ApiRequest;

class SupplierStoreRequest extends ApiRequest
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
            "name" => "required",
            "phone" => "required|string|min:10",
            "contact_name" => "required",
            "website" => "required|url",
            "description" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле name обязательно',
            'phone.required' => 'Поле phone обязательно',
            'contact_name.required' => 'Поле contact_name обязательно',
            'website.required' => 'Поле website обязательно',
            'description.required' => 'Поле description обязательно',
        ];
    }
}
