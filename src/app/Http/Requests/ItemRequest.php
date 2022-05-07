<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    use SanitizesInput;

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
    public function rules(): array
    {
        $name_controller = $this->route()->action['controller'];

        if (str_contains($name_controller, '@store'))
            return $this->validationStore();

        if (str_contains($name_controller, '@update'))
            return $this->validationUpdate();
    }

    /**
     * @return array
     */
    protected function filters(): array
    {
        return [
            'name' => 'trim|strip_tags',
            'price' => 'cast:float',
            'quantity' => 'cast:int',
            'category' => 'trim|strip_tags',
            'specifications.is_physical' => 'cast:bool',
            'specifications.weight' => 'cast:float',
            'specifications.color' => 'trim|strip_tags',
            'specifications.brand' => 'trim|strip_tags',
            'specifications.model' =>  'trim|strip_tags',
            'description'=> 'trim|strip_tags'
        ];
    }

    /**
     * @return array
     */
    private function validationStore(): array
    {
        return [
            'name' => 'required|string|min:1|max:50',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category' => 'required|string|min:3|max:30',
            'specifications' => 'required|array',
            'specifications.is_physical' => 'required|boolean',
            'specifications.weight'  =>  'sometimes|numeric',
            'specifications.color' => 'required|string|min:3|max:30',
            'specifications.brand' => 'required|string|min:3|max:30',
            'specifications.model'=> 'required|string|min:3|max:30',
            'description' => 'required|string|min:30|max:500',
        ];
    }

    /**
     * @return array
     */
    private function validationUpdate(): array
    {
        return [
            'name' => 'sometimes|string|min:1|max:50',
            'price' => 'sometimes|numeric',
            'quantity' => 'sometimes|numeric',
            'category' => 'sometimes|string|min:3|max:30',
            'specifications' => 'sometimes|array',
            'specifications.is_physical' => 'sometimes|boolean',
            'specifications.weight'  =>  'sometimes|numeric',
            'specifications.color' => 'sometimes|string|min:3|max:30',
            'specifications.brand' => 'sometimes|string|min:3|max:30',
            'specifications.model'=> 'sometimes|string|min:3|max:30',
            'description' => 'sometimes|string|min:30|max:500',
        ];
    }
}
