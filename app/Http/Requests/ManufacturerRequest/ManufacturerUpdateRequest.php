<?php

namespace App\Http\Requests\ManufacturerRequest;

use App\Models\Manufacturer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed id
 */
class ManufacturerUpdateRequest extends FormRequest
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
                Rule::unique(Manufacturer::class, 'name')->ignore($this->manufacturer->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nazwa jest obowiązkowa',
            'name.unique' => 'Taki producent już istnieje',
        ];
    }
}
