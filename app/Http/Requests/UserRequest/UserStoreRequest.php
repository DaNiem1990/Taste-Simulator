<?php


namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'email' => [
                'bail',
                'required',
                'email',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'name' => [
                'required',
                'min:4'
            ],
            'password' => [
                'required',
                'min:6'
            ]
        ];
    }


    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.requied' => 'Email jest obowiązkowy',
            'email.email' => 'Poprawny email jest obowiązkowy',
            'email.unique' => 'Inny użytkownik już użył tego adresu email',
            'name.requied' => 'Nazwa jest obowiązkowa',
            'password.required' => 'Hasło jest obowiązkowe',
        ];
    }
}
