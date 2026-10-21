<?php

namespace App\Http\Requests;

use App\Enums\UserRoles;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use App\Traits\MapsArabicFields;
use Illuminate\Validation\Rule;
class RegisterRequest extends FormRequest
{
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
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'role'     => ['required', 'string', Rule::enum(UserRoles::class)->only([UserRoles::STUDENT, UserRoles::INSTRUCTOR])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'يجب إدخال الاسم',
            'name.string'=>'الاسم يجب أن يكون سلسلة نصية',
            'name.max'=> 'الاسم لا يجب أن يتجاوز 255 حرف',

            'email.required' => 'يجب إدخال البريد الالكتروني',
            'email.string' => 'البريد الالكتروني يجب أن يكون سلسلة نصية',
            'email.email' => 'يجب إدخال بريد الالكتروني صالح',
            'email.max' => 'البريد الالكتروني لا يجب ان يتجاوز 255 حرف',
            'email.unique' => 'عذراً، هذا البريد الالكتروني موجود مسبقا يرجى ادخال بريد جديد',

            'password.required' => 'يجب ادخال كلمة المرور',
            'password.min' => 'كلمة المرور لا يجب أن تقل عن 8 أحرف',

            'role.required' => 'يجب إدخال الدور',
            'role.string' => 'الدور يجب أن يكون سللسة نصية',
            'role.enum' => "هذا الدور غير متاح، يرجى إدخال ". UserRoles::STUDENT->value . " أو " . UserRoles::INSTRUCTOR->value,

        ];
    }
}
