<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEmailRequest extends FormRequest
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

        if (str_contains($name_controller, '@requestChangeEmail'))
            return $this->validationRequestChangeEmail();

        if (str_contains($name_controller, '@changeEmail'))
            return $this->validationChangeEmail();
    }

    private function validationRequestChangeEmail(): array
    {
        return [
            'new_email' => 'required|email:rfc,filter|min:20|max:128', //TODO:: Implementar rule "unique"
        ];
    }

    private function validationChangeEmail(): array
    {
        return [
            'new_email' => 'required|email:rfc,filter|min:20|max:128',
            'token' => 'required|uuid'
        ];
    }
}
