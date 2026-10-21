<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\MapsArabicFields;
class LoginRequest extends FormRequest
{
    use MapsArabicFields;
    public function fieldsMapping(): array
    {
        return [
            'البريد الالكتروني' => 'email',
            'كلمة المرور' => "password"
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'يجب إدخال البريد الاكتروني',
            'email.string' => 'البريد الالكتروني يجب أن يكون سلسلة نصية',
            'email.email' => 'يجب إدخال بريد الكتروني صالح',

            'password.required' => 'يجب ادخال كلمة المرور',
            'password.string' => 'يجب ان تكون كلمة المرور سلسلة نصية'

        ];
    }
}
