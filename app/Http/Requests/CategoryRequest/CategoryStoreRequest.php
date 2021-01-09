<?php

namespace App\Http\Requests\CategoryRequest;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
                'unique:categories,name',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.requied' => 'Nazwa jest obowiązkowa',
            'name.unique' => 'Taka kategoria już istnieje',
        ];
    }
}
