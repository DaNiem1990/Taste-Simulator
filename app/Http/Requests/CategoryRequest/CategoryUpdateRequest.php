<?php

namespace App\Http\Requests\CategoryRequest;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed id
 */
class CategoryUpdateRequest extends FormRequest
{
    /**
     * @var mixed
     */

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
                Rule::unique(Category::class, 'name')->ignore($this->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nazwa jest obowiązkowa',
            'name.unique' => 'Taka kategoria już istnieje',
        ];
    }
}
