<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $name_controller = $this->route()->action['controller'];

        if (str_contains($name_controller, '@store'))
            return $this->validationStore();

        if (str_contains($name_controller, '@changeName'))
            return $this->validationChangeName();

        if (str_contains($name_controller, '@setImageProfile'))
            return $this->validationSetImageProfile();
    }

    private function validationStore(): array
    {
        return [
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'email' => 'required|email:rfc,filter|min:20|max:128', //TODO:: Implementar rule "unique"
            'password' => 'required|string|min:8|max:16'
        ];
    }

    private function validationChangeName(): array
    {
        return [
            'first_name' => 'sometimes|string|min:2|max:30',
            'last_name' => 'sometimes|string|min:2|max:30',
        ];
    }

    private function validationSetImageProfile(): array
    {
        return [
            'base64' => 'required|string'
        ];
    }
}
