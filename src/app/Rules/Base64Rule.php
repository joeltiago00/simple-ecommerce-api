<?php

namespace App\Rules;

use App\Exceptions\Base64\Base64Invalid;
use App\Exceptions\File\FileInvalidExtension;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class Base64Rule implements Rule
{
    /**
     * Instance of FormRequest
     *
     * @var Request
     */
    private Request $request;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $resquest)
    {
        $this->request = $resquest;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $base64_raw = explode(';', $value);
            $base64 = explode(',', $base64_raw[1]);

            if ($base64[0] !== 'base64')
                throw new Base64Invalid();

            $ext = explode(':', $base64_raw[0]);

            if (!in_array($ext[1], config('files.extensions_allowed.list')))
                throw new FileInvalidExtension();

            $this->request->merge([
                'media' => [
                    'extension' => config("files.extensions_allowed.$ext[1]"),
                    'file' => $value,
                    'name' => Str::uuid()
                ]
            ]);
        } catch (\Exception $e) {
            //TODO:: (Joel 15/01) Implementar Log
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('general.invalid-base64');
    }
}
