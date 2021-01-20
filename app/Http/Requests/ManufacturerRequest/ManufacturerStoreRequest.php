<?php

namespace App\Http\Requests\ManufacturerRequest;

use Illuminate\Foundation\Http\FormRequest;

class ManufacturerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'required',
                'string',
                'unique:manufacturers,name',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.requied' => 'Nazwa jest obowiązkowa',
            'name.unique' => 'Taki producent już istnieje',
        ];
    }
}
