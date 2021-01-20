<?php

namespace App\Http\Requests\ProductRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed id
 */
class ProductUpdateRequest extends FormRequest
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
                Rule::unique('products')->where(function($query){
                    return $query->where('category_id', $this->category_id)
                                ->where('manufacturer_id', $this->manufacturer_id);
                })->ignore($this->product->id),
            ],
            'category_id' => [
                'required',
                'exists:categories,id'
            ],
            'manufacturer_id' => [
                'required',
                'exists:manufacturers,id'
            ],
        ];
    }


    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.requied' => 'Nazwa jest obowiązkowa',
            'name.unique' => 'Produkt o takiej nazwie już istnieje',
            'category_id.required' => 'Podanie kategorii jest obowiązkowe',
            'category_id.exists' => 'Wybrana kategoria nie istnieje',
            'manufacturer_id.required' => 'Podanie producenta jest obowiązkowe',
            'manufacturer_id.exists' => 'Wybrany producent nie istnieje',
        ];
    }
}
